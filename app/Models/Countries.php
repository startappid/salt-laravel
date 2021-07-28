<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Schema;
use App\Observers\Traits\Fileable;
use App\Traits\ObservableModel;

class Countries extends Resources {

    use ObservableModel;
    use Fileable;

    protected $fileableFields = ['flag'];
    protected $fileableDirs = [
        'flag' => 'countries/flag'
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
        'name',
        'isocode',
        'phonecode'
    ];

    protected $rules = array(
        'name' => 'required|string',
        'isocode' => [
            'create' => 'required|string|max:2|unique:countries',
            'update' => 'required|string|max:2|unique:countries,isocode,{id}',
            'delete' => null,
        ],
        'phonecode' => [
            'create' => 'required|integer|unique:countries',
            'update' => 'required|integer|unique:countries,phonecode,{id}',
            'delete' => null,
        ]
    );

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

    protected $structures = array();
    protected $forms = array();

    protected $searchable = array('name', 'isocode', 'phonecode');

    public function provinces() {
        return $this->hasMany('App\Models\Provinces', 'country_id', 'id');
    }

    public function cities() {
        return $this->hasMany('App\Models\Cities', 'country_id', 'id');
    }

    public function files() {
        return $this->hasMany('App\Models\Files', 'foreign_id', 'id')->where('foreign_table', 'countries');
    }
}
