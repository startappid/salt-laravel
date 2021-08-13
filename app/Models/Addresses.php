<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;
use App\Traits\ObservableModel;

class Addresses extends Resources {
    use ObservableModel;
    protected $rules = [
        'foreign_table' => 'nullable|string',
        'foreign_id' => 'nullable|integer',
        'country_id' => 'required|integer',
        'province_id' => 'required|integer',
        'city_id' => 'required|integer',
        'address' => 'required|string|max:255',
        'postalcode' => 'required|string|max:5',
        'latitude' => 'nullable|float',
        'longitude' => 'nullable|float',
        'type' => [
            'required',
            'string',
            'in:primary,office,home,other'
        ],
        'category' => 'nullable|string',
    ];

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

    protected $forms = array();
    protected $structures = array();

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
