<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use GrammaticalQuery\FilterQueryString\FilterQueryString;

class Resources extends Model {

    use SoftDeletes;
    use FilterQueryString;

    protected $guard_name = 'web';
    protected $limit_chars = 50;

    /**
     * Validation your request
     * Example use single validations for create and update
     * protected $rules = array(
     *      'name' => 'required|unique:users',
     * );
     *
     * Example use different validations for create and update
     * protected $rules = array(
     *      'name' => [
     *          'create' => 'required|unique:users',
     *          'update' => 'nullable|unique:users',
     *      ],
     * );
     */
    protected $rules = array();

    protected $dates = ['deleted_at'];
    protected $dateFormat = 'Y-m-d H:i:s';
    protected $searchable = array();

    protected $filters = [
        'default',
        'search',
        'fields',
        // 'limit',
        // 'page',
        'relationship',
        'withtrashed',
        'orderby',
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
        $validator = Validator::make($request->all(), $rules);
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

    public function getTableFields() {
        return Schema::getColumnListing($this->getTable());
    }

    public function getValidationOf($event = 'create', $id = null) {
        $rules = [];
        if($event == 'patch') $event = 'update';
        foreach ($this->rules as $key => $validation) {
            $rule = $validation;
            if(is_array($validation) && isset($validation[$event])) {
                $rule = $validation[$event];
            }
            $rule = str_replace('{id}', $id, $rule);
            $rules[$key] = $rule;
        }
        return $rules;
    }

    public function checkTableExists($table_name) {
        return Schema::hasTable($table_name);
    }

}
