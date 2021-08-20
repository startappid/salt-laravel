<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Schema;
use App\Traits\ObservableModel;

class Subjects extends Resources {

    use ObservableModel;
    protected $filters = [
        'default',
        'search',
        'fields',
        'relationship',
        'withtrashed',
        'orderby',
        // Fields table
        'id',
        'class_id',
        'title',
        'description',
    ];

    protected $rules = array(
        'class_id' => 'required|integer',
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
        'class_id',
        'title',
        'description',
    );
    protected $searchable = array(
        'class_id',
        'title',
        'description',
    );

    public function class() {
        return $this->belongsTo('App\Models\Classes', 'class_id', 'id')->withTrashed();
    }

}
