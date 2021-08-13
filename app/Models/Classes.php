<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Schema;
use App\Traits\ObservableModel;

class Classes extends Resources {
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
        'level_id',
        'degree_id',
        'major_id',
        'field_id',
        'class',
    ];

    protected $rules = array(
        'level_id' => 'required|integer',
        'degree_id' => 'required|integer',
        'major_id' => 'nullable|integer',
        'field_id' => 'nullable|integer',
        'class' => 'nullable|string'
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
        'level_id',
        'degree_id',
        'major_id',
        'field_id',
        'class',
    );
    protected $searchable = array(
        'level_id',
        'degree_id',
        'major_id',
        'field_id',
        'class',
    );

    public function level() {
        return $this->belongsTo('App\Models\Levels', 'level_id', 'id')->withTrashed();
    }

    public function degree() {
        return $this->belongsTo('App\Models\Degrees', 'degree_id', 'id')->withTrashed();
    }

    public function major() {
        return $this->belongsTo('App\Models\Majors', 'major_id', 'id')->withTrashed();
    }

    public function field() {
        return $this->belongsTo('App\Models\Fields', 'field_id', 'id')->withTrashed();
    }
}
