<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Schema;
use App\Observers\Traits\Fileable;

class Contents extends Resources {

    use Fileable;
    protected $fileableFields = ['image'];
    protected $fileableDirs = [
        'image' => 'partnerships/image',
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
        'title',
        'category',
        'content',
        'type',
    ];

    protected $rules = array(
        "title" => 'required|string',
        "category" => 'nullable|string',
        "content" => 'required|string',
        "type" => 'nullable|string',
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

    protected $searchable = array('title', 'category', 'content', 'type');
    protected $fillable = array('title', 'category', 'content', 'type');

    public function image() {
        return $this->hasOne('App\Models\Files', 'foreign_id', 'id')
                    ->where('foreign_table', 'contents')
                    ->where('directory', 'contents/image');
    }
}
