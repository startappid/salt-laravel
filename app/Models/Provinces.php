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

        "number" => [
            'name' => 'number',
            'default' => null,
            'label' => 'Your number label',
            'display' => true,
            'validation' => [
                'create' => 'required|string',
                'update' => 'required|string',
                'delete' => null,
            ],
            'primary' => false,
            'required' => false,
            'type' => 'number',
            'validated' => true,
            'nullable' => false,
            'note' => 'Help text run here',
            'placeholder' => 'Insert your number',
        ],

        "email" => [
            'name' => 'email',
            'default' => null,
            'label' => 'Your email label',
            'display' => true,
            'validation' => [
                'create' => 'required|email',
                'update' => 'required|email',
                'delete' => null,
            ],
            'primary' => false,
            'required' => false,
            'type' => 'email',
            'validated' => true,
            'nullable' => false,
            'note' => 'Help text run here',
            'placeholder' => 'Insert your email',
        ],

        "checkbox" => [
            'name' => 'checkbox',
            'default' => null,
            'label' => 'Your Checkbox label',
            'display' => true,
            'validation' => [
                'create' => 'required|array',
                'update' => 'required|array',
                'delete' => null,
            ],
            'primary' => false,
            'required' => false,
            'type' => 'checkbox',
            'validated' => true,
            'nullable' => false,
            'note' => 'Help text run here',
            'placeholder' => null,
            // Options checkbox
            'inline' => false,
            'options' => [
                [
                    'value' => 1,
                    'label' => 'Option 1'
                ],
                [
                    'value' => 2,
                    'label' => 'Option 2'
                ],
                [
                    'value' => 3,
                    'label' => 'Option 3'
                ],
            ],
            // Options disabled according to value
            'options_disabled' => [2]
        ],

        "checkbox_inline" => [
            'name' => 'checkbox_inline',
            'default' => 1,
            'label' => 'Your Checkbox label',
            'display' => true,
            'validation' => [
                'create' => 'required|array',
                'update' => 'required|array',
                'delete' => null,
            ],
            'primary' => false,
            'required' => false,
            'type' => 'checkbox',
            'validated' => true,
            'nullable' => false,
            'note' => 'Help text run here',
            'placeholder' => null,
            // Options checkbox
            'inline' => true,
            'options' => [
                [
                    'value' => 1,
                    'label' => 'Option 1'
                ],
                [
                    'value' => 2,
                    'label' => 'Option 2'
                ],
                [
                    'value' => 3,
                    'label' => 'Option 3'
                ],
            ],
            // Options disabled according to value
            'options_disabled' => [2]
        ],

        "radio" => [
            'name' => 'radio',
            'default' => null,
            'label' => 'Your radio label',
            'display' => true,
            'validation' => [
                'create' => 'required|string',
                'update' => 'required|string',
                'delete' => null,
            ],
            'primary' => false,
            'required' => false,
            'type' => 'radio',
            'validated' => true,
            'nullable' => false,
            'note' => 'Help text run here',
            'placeholder' => null,
            // Options checkbox
            'inline' => false,
            'options' => [
                [
                    'value' => 1,
                    'label' => 'Option 1'
                ],
                [
                    'value' => 2,
                    'label' => 'Option 2'
                ],
                [
                    'value' => 3,
                    'label' => 'Option 3'
                ],
            ],
            // Options disabled according to value
            'options_disabled' => [2]
        ],

        "radio_inline" => [
            'name' => 'radio_inline',
            'default' => 1,
            'label' => 'Your radio label',
            'display' => true,
            'validation' => [
                'create' => 'required|string',
                'update' => 'required|string',
                'delete' => null,
            ],
            'primary' => false,
            'required' => false,
            'type' => 'radio',
            'validated' => true,
            'nullable' => false,
            'note' => 'Help text run here',
            'placeholder' => null,
            // Options checkbox
            'inline' => true,
            'options' => [
                [
                    'value' => 1,
                    'label' => 'Option 1'
                ],
                [
                    'value' => 2,
                    'label' => 'Option 2'
                ],
                [
                    'value' => 3,
                    'label' => 'Option 3'
                ],
            ],
            // Options disabled according to value
            'options_disabled' => [2]
        ],

        "color" => [
            'name' => 'color',
            'default' => null,
            'label' => 'Your color label',
            'display' => true,
            'validation' => [
                'create' => 'required|string',
                'update' => 'required|string',
                'delete' => null,
            ],
            'primary' => false,
            'required' => false,
            'type' => 'color',
            'validated' => true,
            'nullable' => false,
            'note' => 'Help text run here',
            'placeholder' => 'Pick your color',
        ],

        "date" => [
            'name' => 'date',
            'default' => null,
            'label' => 'Your date label',
            'display' => true,
            'validation' => [
                'create' => 'required|string',
                'update' => 'required|string',
                'delete' => null,
            ],
            'primary' => false,
            'required' => false,
            'type' => 'date',
            'validated' => true,
            'nullable' => false,
            'note' => 'Help text run here',
            'placeholder' => 'Pick your color',
        ],

        "time" => [
            'name' => 'time',
            'default' => null,
            'label' => 'Your time label',
            'display' => true,
            'validation' => [
                'create' => 'required|string',
                'update' => 'required|string',
                'delete' => null,
            ],
            'primary' => false,
            'required' => false,
            'type' => 'time',
            'validated' => true,
            'nullable' => false,
            'note' => 'Help text run here',
            'placeholder' => 'Pick your color',
        ],

        "datetime" => [
            'name' => 'datetime',
            'default' => null,
            'label' => 'Your datetime label',
            'display' => true,
            'validation' => [
                'create' => 'required|string',
                'update' => 'required|string',
                'delete' => null,
            ],
            'primary' => false,
            'required' => false,
            'type' => 'datetime',
            'validated' => true,
            'nullable' => false,
            'note' => 'Help text run here',
            'placeholder' => 'Pick your color',
        ],

        "hidden" => [
            'name' => 'hidden',
            'default' => 1,
            'label' => 'Your hidden label',
            'display' => true,
            'validation' => [
                'create' => 'required|string',
                'update' => 'required|string',
                'delete' => null,
            ],
            'primary' => false,
            'required' => false,
            'type' => 'hidden',
            'validated' => true,
            'nullable' => false,
            'note' => null,
            'placeholder' => null,
        ],

        "password" => [
            'name' => 'password',
            'default' => null,
            'label' => 'Your password label',
            'display' => true,
            'validation' => [
                'create' => 'required|string',
                'update' => 'required|string',
                'delete' => null,
            ],
            'primary' => false,
            'required' => true,
            'type' => 'password',
            'validated' => true,
            'nullable' => false,
            'note' => null,
            'placeholder' => null,
        ],

        "range" => [
            'name' => 'range',
            'default' => null,
            'label' => 'Your range label',
            'display' => true,
            'validation' => [
                'create' => 'required|string',
                'update' => 'required|string',
                'delete' => null,
            ],
            'primary' => false,
            'required' => true,
            'type' => 'range',
            'validated' => true,
            'nullable' => false,
            'note' => 'Help text run here',
            'placeholder' => null,
            // RANGE OPTION
            'step' => 1,
            'min' => 0,
            'max' => 10
        ],

        "telephone" => [
            'name' => 'telephone',
            'default' => null,
            'label' => 'Your telephone label',
            'display' => true,
            'validation' => [
                'create' => 'required|string',
                'update' => 'required|string',
                'delete' => null,
            ],
            'primary' => false,
            'required' => true,
            'type' => 'tel',
            'validated' => true,
            'nullable' => false,
            'note' => 'Help text run here',
            'placeholder' => 'Insert your telephone',
        ],

        "url" => [
            'name' => 'url',
            'default' => null,
            'label' => 'Your url label',
            'display' => true,
            'validation' => [
                'create' => 'required|string',
                'update' => 'required|string',
                'delete' => null,
            ],
            'primary' => false,
            'required' => true,
            'type' => 'url',
            'validated' => true,
            'nullable' => false,
            'note' => 'Help text run here',
            'placeholder' => 'Insert your telephone',
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
