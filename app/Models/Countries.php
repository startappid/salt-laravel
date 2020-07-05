<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Model;
use DB;
use App\Observers\CountriesObserver as Observer;
use Illuminate\Support\Facades\Schema;

class Countries extends Resources {

    protected $rules = array(
        'name' => 'required|string',
        'isocode' => 'required|string|max:2|unique:countries',
        'phonecode' => 'required|integer|unique:countries'
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
        "isocode" => [
            'name' => 'isocode',
            'label' => 'ISO Code',
            'display' => false,
            'validation' => [
                'create' => 'required|string|max:2|unique:countries',
                'update' => 'required|string|max:2|unique:countries,isocode,{id}',
                'delete' => null,
            ],
            'primary' => false,
            'type' => 'text',
            'validated' => true,
            'nullable' => false,
            'note' => null
        ],
        "phonecode" => [
            'name' => 'phonecode',
            'label' => 'Phone Code',
            'display' => false,
            'validation' => [
                'create' => 'required|integer|unique:countries',
                'update' => 'required|integer|unique:countries,isocode,{id}',
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

    protected $searchable = array('name', 'isocode', 'phonecode');

    // FIXME: remove thi line below on production
    protected $auths = array ();

    //  OBSERVER
    protected static function boot() {
        parent::boot();
        static::observe(Observer::class);
    }

    public function provinces() {
        return $this->hasMany('App\Models\Provinces', 'country_id', 'id');
    }

    public function cities() {
        return $this->hasMany('App\Models\Cities', 'country_id', 'id');
    }
}
