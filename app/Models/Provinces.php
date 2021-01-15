<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Model;
use DB;
use App\Observers\ProvincesObserver as Observer;
use Illuminate\Support\Facades\Schema;

class Provinces extends Resources {

    protected $rules = array(
        'country_id' => 'required|integer',
        'name' => 'required|string',
        'isocode' => 'nullable|string|max:5'
    );

    protected $structures = array(
        "id" => [
            'name' => 'id',
            'default' => null,
            'label' => 'ID',
            'display' => false,
            'validation' => [
                'create' => null,
                'update' => null,
                'delete' => null,
            ],
            'primary' => true,
            'required' => true,
            'type' => 'integer',
            'validated' => false,
            'nullable' => false,
            'note' => null
        ],


        "fullname" => [
            'name' => 'fullname',
            'default' => null,
            'label' => 'Your full name label',
            'display' => true,
            'validation' => [
                'create' => 'required|string',
                'update' => 'required|string',
                'delete' => null,
            ],
            'primary' => false,
            'required' => true,
            'type' => 'text',
            'validated' => true,
            'nullable' => false,
            'note' => 'Help text run here',
            'placeholder' => 'Insert your full name',
        ],

        // "name" => [
        //     'name' => 'name',
        //     'label' => 'Name',
        //     'display' => false,
        //     'validation' => [
        //         'create' => 'required|string',
        //         'update' => 'required|string',
        //         'delete' => null,
        //     ],
        //     'primary' => false,
        //     'type' => 'text',
        //     'validated' => true,
        //     'nullable' => false,
        //     'note' => null
        // ],
        // "isocode" => [
        //     'name' => 'isocode',
        //     'label' => 'ISO Code',
        //     'display' => false,
        //     'validation' => [
        //         'create' => 'required|string|max:5|unique:provinces',
        //         'update' => 'required|string|max:5|unique:provinces,isocode,{id}',
        //         'delete' => null,
        //     ],
        //     'primary' => false,
        //     'type' => 'text',
        //     'validated' => true,
        //     'nullable' => false,
        //     'note' => null
        // ],
        // "country_id" => [
        //     'name' => 'country_id',
        //     'label' => 'Country',
        //     'display' => false,
        //     'validation' => [
        //         'create' => 'required|integer',
        //         'update' => 'required|integer',
        //         'delete' => null,
        //     ],
        //     'primary' => false,
        //     'type' => 'integer',
        //     'validated' => true,
        //     'nullable' => false,
        //     'note' => null
        // ],

        "created_at" => [
            'name' => 'created_at',
            'default' => null,
            'label' => 'Created At',
            'display' => false,
            'validation' => [
                'create' => null,
                'update' => null,
                'delete' => null,
            ],
            'primary' => false,
            'required' => false,
            'type' => 'datetime',
            'validated' => false,
            'nullable' => false,
            'note' => null
        ],
        "updated_at" => [
            'name' => 'updated_at',
            'default' => null,
            'label' => 'Updated At',
            'display' => false,
            'validation' => [
                'create' => null,
                'update' => null,
                'delete' => null,
            ],
            'primary' => false,
            'required' => false,
            'type' => 'datetime',
            'validated' => false,
            'nullable' => false,
            'note' => null
        ],
        "deleted_at" => [
            'name' => 'deleted_at',
            'default' => null,
            'label' => 'Deleted At',
            'display' => false,
            'validation' => [
                'create' => null,
                'update' => null,
                'delete' => null,
            ],
            'primary' => false,
            'required' => false,
            'type' => 'datetime',
            'validated' => false,
            'nullable' => false,
            'note' => null
        ]
    );

    protected $searchable = array('name', 'isocode');
    protected $casts = [
        'country' => 'array',
    ];

    //  OBSERVER
    protected static function boot() {
        parent::boot();
        static::observe(Observer::class);
    }

    public function country() {
        return $this->belongsTo('App\Models\Countries', 'country_id', 'id');
    }

    public function cities() {
        return $this->hasMany('App\Models\Cities', 'province_id', 'id');
    }

}
