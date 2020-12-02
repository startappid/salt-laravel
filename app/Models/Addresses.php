<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Schema;

class Addresses extends Resources {

    protected $rules = array(
        'country_id' => 'required|integer',
        'province_id' => 'required|integer',
        'city_id' => 'required|integer',
        'address' => 'required|string|max:255',
        'postalcode' => 'required|string|max:5',
        'latitude' => 'nullable|float',
        'longitude' => 'nullable|float'
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
            'type' => 'text',
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
            'type' => 'text',
            'validated' => true,
            'nullable' => false,
            'note' => null
        ],
        "city_id" => [
            'name' => 'city_id',
            'label' => 'City',
            'display' => false,
            'validation' => [
                'create' => 'required|integer',
                'update' => 'required|integer',
                'delete' => null,
            ],
            'primary' => false,
            'type' => 'text',
            'validated' => true,
            'nullable' => false,
            'note' => null
        ],
        "address" => [
            'name' => 'address',
            'label' => 'Address',
            'display' => false,
            'validation' => [
                'create' => 'required|string|max:255',
                'update' => 'required|string|max:255',
                'delete' => null,
            ],
            'primary' => false,
            'type' => 'text',
            'validated' => true,
            'nullable' => false,
            'note' => null
        ],
        "postalcode" => [
            'name' => 'postalcode',
            'label' => 'Postal Code',
            'display' => false,
            'validation' => [
                'create' => 'required|string|max:5',
                'update' => 'required|string|max:5',
                'delete' => null,
            ],
            'primary' => false,
            'type' => 'text',
            'validated' => true,
            'nullable' => false,
            'note' => null
        ],
        "latitude" => [
            'name' => 'latitude',
            'label' => 'Latitude',
            'display' => false,
            'validation' => [
                'create' => 'nullable|float',
                'update' => 'nullable|float',
                'delete' => null,
            ],
            'primary' => false,
            'type' => 'text',
            'validated' => true,
            'nullable' => false,
            'note' => null
        ],
        "longitude" => [
            'name' => 'longitude',
            'label' => 'Longitude',
            'display' => false,
            'validation' => [
                'create' => 'nullable|float',
                'update' => 'nullable|float',
                'delete' => null,
            ],
            'primary' => false,
            'type' => 'text',
            'validated' => true,
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

    protected $searchable = array('country_id', 'province_id', 'city_id', 'address', 'postalcode', 'latitude', 'longitude');

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
