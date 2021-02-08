<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Model;
use DB;
use App\Observers\Observer as Observer;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class Resources extends Model {

    use SoftDeletes;

    protected $guard_name = 'web';
    protected $limit_chars = 50;
    protected $rules = array();
    protected $dates = ['deleted_at'];
    protected $dateFormat = 'Y-m-d H:i:s';
    protected $searchable = array();
    protected $messages = [
        'required' => 'The :attribute field is required.',
        'unique'  => 'The :attribute field is unique.',
        'same'    => 'The :attribute and :other must match.',
        'size'    => 'The :attribute must be exactly :size.',
        'between' => 'The :attribute value :input is not between :min - :max.',
        'in'      => 'The :attribute must be one of the following types: :values',
    ];

    // NOTE: 'index' and 'show' set as default for public consumption
    protected $auths = array (
        'index',
        'store',
        'show',
        'update',
        'patch',
        'destroy',
        'trash',
        'trashed',
        'restore',
        'delete',
        'import',
        'export',
        'report'
    );

    protected $pemissions = array(
        'create' => ['*.*.*', '*.create.*'],
        'read' => ['*.*.*', '*.read.*'],
        'update' => ['*.*.*', '*.update.*'],
        'restore' => ['*.*.*', '*.restore.*'],
        'destroy' => ['*.*.*', '*.destroy.*'],
        'trash' => ['*.*.*', '*.trash.*'],
        'delete' => ['*.*.*', '*.delete.*'],
        'empty' => ['*.*.*', '*.empty.*'],
        'import' => ['*.*.*', '*.import.*'],
        'export' => ['*.*.*', '*.export.*'],
        'report' => ['*.*.*', '*.report.*'],
    );

    protected $forms = array();
    protected $structures = array(
        "id" => [
            'name' => 'id',
            'label' => 'ID',
            'display' => false,
            'validation' => [
                'create' => null,
                'update' => null,
                'delete' => null,
            ],
            'primary' => true,
            'type' => 'integer',
            'validated' => false,
            'nullable' => false,
            'note' => null
        ],
        "created_at" => [
            'name' => 'created_at',
            'label' => 'Created At',
            'display' => false,
            'validation' => [
                'create' => null,
                'update' => null,
                'delete' => null,
            ],
            'primary' => false,
            'type' => 'datetime',
            'validated' => false,
            'nullable' => false,
            'note' => null
        ],
        "updated_at" => [
            'name' => 'updated_at',
            'label' => 'Updated At',
            'display' => false,
            'validation' => [
                'create' => null,
                'update' => null,
                'delete' => null,
            ],
            'primary' => false,
            'type' => 'datetime',
            'validated' => false,
            'nullable' => false,
            'note' => null
        ],
        "deleted_at" => [
            'name' => 'deleted_at',
            'label' => 'Deleted At',
            'display' => false,
            'validation' => [
                'create' => null,
                'update' => null,
                'delete' => null,
            ],
            'primary' => false,
            'type' => 'datetime',
            'validated' => false,
            'nullable' => false,
            'note' => null
        ]
    );

    //  OBSERVER
    protected static function boot() {
        parent::boot();

        $isApi = request()->segment(1);
        if($isApi == 'api') $table = request()->segment(3);
        else $table = request()->segment(1);

        if(file_exists(app_path('Observers/'.Str::studly($table)).'Observer.php')) {
            $observer = app("App\Observers\\".Str::studly($table).'Observer');
            static::observe($observer);
            return;
        }
        static::observe(Observer::class);
    }

    function setRules($rules) {
        $this->rules = $rules;
    }

    function getAuthenticatedRoutes() {
        return $this->auths;
    }

    function getPermissions($index) {
        return $this->pemissions[$index];
    }

    function getRules() {
        return $this->rules;
    }

    function getSearchable() {
        return $this->searchable;
    }

    public function getMessages() {
        return $this->messages;
    }

    public function getForms() {
        return $this->forms;
    }

    public function validator($request, $event = 'create', $id = null) {
        $rules = $this->getValidationOf($event, $id);
        if($event == 'patch') {
            foreach ($rules as $key => $value) {
                if(!$request->has($key)) {
                    unset($rules[$key]);
                }
            }
        }

        $messages = $this->messages;
        $validator = Validator::make($request->all(), $rules, $messages);
        // NOTE: add some custom validator below
        // $validator->after(function ($validator) use ($request) {
        //   if ($request->get('field_name')) {
        //     if (true) {
        //       $validator->errors()->add('field_name', 'Error goes here');
        //     }
        //   }
        // });
        return $validator;
    }

    public function getStructure() {
        $not_displayed = array_merge(array("id", "created_at", "updated_at", "deleted_at"), $this->getHidden());
        $structures = Schema::getColumnListing($this->getTable());
        $fields = array();
        foreach ($this->structures as $key => $field) {
            // FIXME: how about field hide on show data and displayed on create/update
            if(in_array($field['name'], $not_displayed)) {
                $this->structures[$key]['display'] = false;
            }
        }
        return $this->structures;
    }

    public function getValidationOf($event = 'create', $id = null) {
        $rules = [];
        if($event == 'patch') $event = 'update';
        foreach ($this->structures as $key => $value) {
            if($value['validated']) {
                $validation = null;
                if($event == 'create') {
                    $validation = $value['validation'][$event];
                } elseif($event == 'update' || $event == 'patch') {
                    $validation = str_replace('{id}', $id, $value['validation'][$event]);
                } else {
                    $validation = $value['validation'][$event];
                }
                $rules[$key] = $validation;
            }
        }
        return $rules;
    }

    public function checkTableExists($table_name) {
        return Schema::hasTable($table_name);
    }

}
