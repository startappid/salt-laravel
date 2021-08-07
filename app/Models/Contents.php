<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Schema;
use App\Observers\Traits\Fileable;
use App\Traits\ObservableModel;

class Contents extends Resources {
    use ObservableModel;
    use Fileable;
    protected $fileableFields = ['image', 'thumbnail', 'banner'];
    protected $fileableCascade = [
        'thumbnail' => true,
        'image' => true,
        'banner' => true
    ];
    protected $fileableDirs = [
        'thumbnail' => 'posts/thumbnail',
        'image' => 'posts/image',
        'banner' => 'posts/banner',
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
                    ->where('directory', 'posts/image');
    }

    public function banner() {
        return $this->hasOne('App\Models\Files', 'foreign_id', 'id')
                    ->where('foreign_table', 'contents')
                    ->where('directory', 'posts/banner');
    }

    public function thumbnail() {
        return $this->hasOne('App\Models\Files', 'foreign_id', 'id')
                    ->where('foreign_table', 'contents')
                    ->where('directory', 'posts/thumbnail');
    }

}
