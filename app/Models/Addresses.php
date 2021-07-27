<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Schema;

class Addresses extends Resources {

    protected $rules = array(
        'foreign_table' => 'nullable|string',
        'foreign_id' => 'nullable|integer',
        'country_id' => 'required|integer',
        'province_id' => 'required|integer',
        'city_id' => 'required|integer',
        'address' => 'required|string|max:1024',
        'postalcode' => 'required|string|max:5',
        'latitude' => 'nullable|float',
        'longitude' => 'nullable|float',
    );

    protected $filters = [
        'default',
        'search',
        'fields',
        'relationship',
        'withtrashed',
        'orderby',
        // Fields table provinces
        'id',
        'country_id',
        'province_id',
        'city_id',
        'address',
        'postalcode',
        'latitude',
        'longitude',
        'foreign_table',
        'foreign_id'
    ];

    protected $auths = array (
        // 'index',
        'store',
        // 'show',
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

    protected $forms = array(
        [
            [
                'class' => 'col-4',
                'field' => 'country_id'
            ],
            [
                'class' => 'col-4',
                'field' => 'province_id'
            ],
            [
                'class' => 'col-4',
                'field' => 'city_id'
            ]
        ],
        [
            [
                'class' => 'col',
                'field' => 'address'
            ]
        ],
        [
            [
                'class' => 'col-2',
                'field' => 'postalcode'
            ],
            [
                'class' => 'col-3',
                'field' => 'latitude'
            ],
            [
                'class' => 'col-3',
                'field' => 'longitude'
            ]
        ],
        [
            [
                'class' => 'col-2',
                'field' => 'type'
            ],
            [
                'class' => 'col-4',
                'field' => 'category'
            ]
        ],
        [
            [
                'class' => 'col-2',
                'field' => 'foreign_table'
            ],
            [
                'class' => 'col-2',
                'field' => 'foreign_id'
            ],
        ]
    );

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
        "foreign_table" => [
            'name' => 'foreign_table',
            'label' => 'Foreign Table',
            'display' => true,
            'validation' => [
                'create' => 'nullable|string',
                'update' => 'nullable|string',
                'delete' => null,
            ],
            'required' => false,
            'primary' => false,
            'type' => 'text',
            'validated' => true,
            'nullable' => false,
            'note' => null,
            'placeholder' => null,
        ],
        "foreign_id" => [
            'name' => 'foreign_id',
            'label' => 'Foreign ID',
            'display' => true,
            'validation' => [
                'create' => 'nullable|integer',
                'update' => 'nullable|integer',
                'delete' => null,
            ],
            'required' => false,
            'primary' => false,
            'type' => 'text',
            'validated' => true,
            'nullable' => false,
            'note' => null,
            'placeholder' => null,
        ],
        "country_id" => [
            'name' => 'country_id',
            'label' => 'Country',
            'display' => true,
            'validation' => [
                'create' => 'required|integer',
                'update' => 'required|integer',
                'delete' => null,
            ],
            'required' => true,
            'primary' => false,
            'type' => 'reference',
            'validated' => true,
            'nullable' => false,
            'note' => null,
            'placeholder' => null,// Options reference
            'reference' => "countries", // Select2 API endpoint => /api/v1/countries
            'relationship' => 'country', // relationship request datatable
            'option' => [
                'value' => 'id',
                'label' => 'name'
            ]
        ],
        "province_id" => [
            'name' => 'province_id',
            'label' => 'Province',
            'display' => true,
            'validation' => [
                'create' => 'required|integer',
                'update' => 'required|integer',
                'delete' => null,
            ],
            'required' => true,
            'primary' => false,
            'type' => 'reference',
            'validated' => true,
            'nullable' => false,
            'note' => null,
            'placeholder' => null,// Options reference
            'reference' => "provinces", // Select2 API endpoint => /api/v1/countries
            'relationship' => 'province', // relationship request datatable
            'option' => [
                'value' => 'id',
                'label' => 'name'
            ]
        ],
        "city_id" => [
            'name' => 'city_id',
            'label' => 'City',
            'display' => true,
            'validation' => [
                'create' => 'required|integer',
                'update' => 'required|integer',
                'delete' => null,
            ],
            'required' => true,
            'primary' => false,
            'type' => 'reference',
            'validated' => true,
            'nullable' => false,
            'note' => null,
            'placeholder' => null,// Options reference
            'reference' => "cities", // Select2 API endpoint => /api/v1/countries
            'relationship' => 'city', // relationship request datatable
            'option' => [
                'value' => 'id',
                'label' => 'name'
            ]
        ],
        "address" => [
            'name' => 'address',
            'label' => 'Address',
            'display' => true,
            'validation' => [
                'create' => 'required|string|max:255',
                'update' => 'required|string|max:255',
                'delete' => null,
            ],
            'required' => true,
            'primary' => false,
            'type' => 'text',
            'validated' => true,
            'nullable' => false,
            'note' => null,
            'placeholder' => null,
        ],
        "postalcode" => [
            'name' => 'postalcode',
            'label' => 'Postal Code',
            'display' => true,
            'validation' => [
                'create' => 'required|string|max:5',
                'update' => 'required|string|max:5',
                'delete' => null,
            ],
            'required' => true,
            'primary' => false,
            'type' => 'text',
            'validated' => true,
            'nullable' => false,
            'note' => null,
            'placeholder' => null,
        ],
        "latitude" => [
            'name' => 'latitude',
            'label' => 'Latitude',
            'display' => true,
            'validation' => [
                'create' => 'nullable|float',
                'update' => 'nullable|float',
                'delete' => null,
            ],
            'required' => false,
            'primary' => false,
            'type' => 'text',
            'validated' => true,
            'nullable' => false,
            'note' => null,
            'placeholder' => null,
        ],
        "longitude" => [
            'name' => 'longitude',
            'label' => 'Longitude',
            'display' => true,
            'validation' => [
                'create' => 'nullable|float',
                'update' => 'nullable|float',
                'delete' => null,
            ],
            'required' => false,
            'primary' => false,
            'type' => 'text',
            'validated' => true,
            'nullable' => false,
            'note' => null,
            'placeholder' => null,
        ],
        "type" => [
            'name' => 'type',
            'default' => 'other',
            'label' => 'Type',
            'display' => true,
            'validation' => [
                'create' => 'required|string',
                'update' => 'required|string',
                'delete' => null,
            ],
            'primary' => false,
            'required' => true,
            'type' => 'radio',
            'validated' => true,
            'nullable' => false,
            'note' => '— Address Type',
            'placeholder' => null,
            // Options checkbox
            'inline' => true,
            'options' => [
                [
                    'value' => 'primary',
                    'label' => 'Primary'
                ],
                [
                    'value' => 'other',
                    'label' => 'Other'
                ],
            ],
            // Options disabled according to value
            'options_disabled' => []
        ],
        "category" => [
            'name' => 'category',
            'label' => 'Category',
            'display' => true,
            'validation' => [
                'create' => 'nullable|string',
                'update' => 'nullable|string',
                'delete' => null,
            ],
            'required' => false,
            'primary' => false,
            'type' => 'text',
            'validated' => true,
            'nullable' => false,
            'note' => null,
            'placeholder' => null,
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

    protected $searchable = array('country_id', 'province_id', 'city_id', 'address', 'postalcode', 'latitude', 'longitude', 'foreign_table', 'foreign_id');
    protected $fillable = array('country_id', 'province_id', 'city_id', 'address', 'postalcode', 'latitude', 'longitude', 'foreign_table', 'foreign_id');

    public function country() {
        return $this->belongsTo('App\Models\Countries', 'country_id', 'id');
    }

    public function province() {
        return $this->belongsTo('App\Models\Provinces', 'province_id', 'id');
    }

    public function city() {
        return $this->belongsTo('App\Models\Cities', 'city_id', 'id');
    }
}
