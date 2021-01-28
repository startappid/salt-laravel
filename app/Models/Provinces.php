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

    protected $forms = array(
        [
            [
                'class' => 'col-2',
                'field' => 'country_id'
            ],
            [
                'class' => 'col-6',
                'field' => 'name'
            ],
            [
                'class' => 'col-2',
                'field' => 'isocode'
            ]
        ],
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

        "name" => [
            'name' => 'name',
            'default' => null,
            'label' => 'Province',
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
            'note' => null,
            'placeholder' => 'Province',
        ],
        "isocode" => [
            'name' => 'isocode',
            'default' => null,
            'label' => 'ISO Code',
            'display' => true,
            'validation' => [
                'create' => 'required|string|max:5|unique:provinces',
                'update' => 'required|string|max:5|unique:provinces,isocode,{id}',
                'delete' => null,
            ],
            'primary' => false,
            'required' => true,
            'type' => 'text',
            'validated' => true,
            'nullable' => false,
            'note' => null,
            'placeholder' => 'ISO Code',
        ],

        "country_id" => [
            'name' => 'country_id',
            'default' => null,
            'label' => 'Country',
            'display' => true,
            'validation' => [
                'create' => 'required|integer',
                'update' => 'required|integer',
                'delete' => null,
            ],
            'primary' => false,
            'required' => true,
            'type' => 'reference',
            'validated' => true,
            'nullable' => false,
            'note' => null,
            'placeholder' => 'Country',
            // Options reference
            'reference' => "countries", // Select2 API endpoint => /api/v1/countries
            'relationship' => 'country', // relationship request datatable
            'option' => [
                'value' => 'id',
                'label' => 'name'
            ]
        ],

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
        return $this->belongsTo('App\Models\Countries', 'country_id', 'id')->withTrashed();
    }

    public function cities() {
        return $this->hasMany('App\Models\Cities', 'province_id', 'id')->withTrashed();
    }

}
