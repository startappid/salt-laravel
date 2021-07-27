<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Schema;

class Cities extends Resources {

    protected $filters = [
        'default',
        'search',
        'fields',
        // 'limit',
        // 'page',
        'relationship',
        'withtrashed',
        'orderby',
        // Fields table provinces
        'id',
        'name',
        'country_id',
        'province_id'
    ];

    protected $rules = array();

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
                'class' => 'col-2',
                'field' => 'country_id'
            ],
            [
                'class' => 'col-2',
                'field' => 'province_id'
            ],
            [
                'class' => 'col',
                'field' => 'name'
            ],
        ],
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
        "name" => [
            'name' => 'name',
            'label' => 'Name',
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
            'placeholder' => 'Name',
            'note' => null
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
        "province_id" => [
            'name' => 'province_id',
            'label' => 'Province',
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
            'reference' => "provinces", // Select2 API endpoint => /api/v1/countries
            'relationship' => 'province', // relationship request datatable
            'option' => [
                'value' => 'id',
                'label' => 'name'
            ]
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

    protected $searchable = array('name', 'country_id', 'province_id');
    protected $fillable = array('name', 'country_id', 'province_id');
    protected $casts = [
        'country' => 'array',
        'province' => 'array',
    ];

    public function country() {
        return $this->belongsTo('App\Models\Countries', 'country_id', 'id')->withTrashed();
    }

    public function province() {
        return $this->belongsTo('App\Models\Provinces', 'province_id', 'id')->withTrashed();
    }

}
