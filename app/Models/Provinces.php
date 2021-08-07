<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Schema;
use App\Traits\ObservableModel;
class Provinces extends Resources {
    use ObservableModel;
    protected $filters = [
        'default',
        'search',
        'fields',
        'limit',
        'page',
        'relationship',
        'withtrashed',
        'orderby',
        // Fields table provinces
        'id',
        'name',
        'country_id'
    ];

    protected $rules = array(
        'country_id' => 'required|integer',
        'name' => 'required|string'
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

    protected $forms = array();
    protected $structures = array();

    protected $searchable = array('name', 'country_id');
    protected $fillable = array('name', 'country_id');
    protected $casts = [
        'country' => 'array',
    ];

    public function country() {
        return $this->belongsTo('App\Models\Countries', 'country_id', 'id')->withTrashed();
    }

    public function cities() {
        return $this->hasMany('App\Models\Cities', 'province_id', 'id')->withTrashed();
    }

}
