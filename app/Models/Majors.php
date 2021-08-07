<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Schema;

class Majors extends Resources {

    protected $filters = [
        'default',
        'search',
        'fields',
        'relationship',
        'withtrashed',
        'orderby',
        // Fields table
        'id',
        'degree_id',
        'title',
        'description'
    ];

    protected $rules = array(
        'degree_id' => 'required|integer',
        'title' => 'required|string',
        'description' => 'nullable|string'
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
    protected $fillable = array(
        'degree_id',
        'title',
        'description'
    );
    protected $searchable = array(
        'degree_id',
        'title',
        'description'
    );

    public function degree() {
        return $this->belongsTo('App\Models\Degrees', 'degree_id', 'id')->withTrashed();
    }
}
