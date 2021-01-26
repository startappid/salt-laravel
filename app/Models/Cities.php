<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Model;
use DB;
use App\Observers\CitiesObserver as Observer;
use Illuminate\Support\Facades\Schema;

class Cities extends Resources {

    protected $rules = array();

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
        "name" => [
            'name' => 'name',
            'label' => 'Name',
            'display' => false,
            'validation' => [
                'create' => 'required|string',
                'update' => 'required|string',
                'delete' => null,
            ],
            'primary' => false,
            'type' => 'text',
            'validated' => true,
            'nullable' => false,
            'note' => null
        ],
        "country_id" => [
            'name' => 'country_id',
            'label' => 'Country',
            'display' => false,
            'validation' => [
                'create' => 'required|integer',
                'update' => 'required|integer',
                'delete' => null,
            ],
            'primary' => false,
            'type' => 'integer',
            'validated' => true,
            'nullable' => false,
            'note' => null
        ],
        "province_id" => [
            'name' => 'province_id',
            'label' => 'Province',
            'display' => false,
            'validation' => [
                'create' => 'required|integer',
                'update' => 'required|integer',
                'delete' => null,
            ],
            'primary' => false,
            'type' => 'integer',
            'validated' => true,
            'nullable' => false,
            'note' => null
        ],
        // "province" => [
        //     'name' => 'province',
        //     'label' => 'Province',
        //     'display' => false,
        //     'validation' => [
        //         'create' => 'nullable|json',
        //         'update' => 'nullable|json',
        //         'delete' => null,
        //     ],
        //     'primary' => false,
        //     'type' => 'json',
        //     'validated' => true,
        //     'nullable' => false,
        //     'note' => null
        // ],
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

    protected $searchable = array('name');
    protected $casts = [
        'country' => 'array',
        'province' => 'array',
    ];

    //  OBSERVER
    protected static function boot() {
        parent::boot();
        static::observe(Observer::class);
    }

    public function country() {
        return $this->belongsTo('App\Models\Countries', 'country_id', 'id')->withTrashed();
    }

    public function province() {
        return $this->belongsTo('App\Models\Provinces', 'province_id', 'id')->withTrashed();
    }

}
