<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Schema;
use App\Observers\Traits\Fileable;
use App\Traits\ObservableModel;

class Banners extends Resources {
    use ObservableModel;
    use Fileable;
    protected $fileableFields = ['video', 'banner'];
    protected $fileableCascade = true;
    protected $fileableDirs = [
        'video' => 'banners/video',
        'banner' => 'banners/image',
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
        'description',
        'status',
        'type',
        'videourl',
        'order'
    ];

    protected $rules = array(
        "title" => 'required|string',
        "description" => 'required|string',
        "status" => 'nullable|string',
        "type" => 'nullable|string',
        "videourl" => 'nullable|string',
        "order" => 'required|integer',
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
    protected $searchable = array( 'title', 'description', 'status', 'type','videourl','order', 'link');
    protected $fillable = array( 'title', 'description', 'status', 'type','videourl','order', 'link');

    public function banner() {
        return $this->hasOne('App\Models\Files', 'foreign_id', 'id')
                    ->where('foreign_table', 'banners')
                    ->where('directory', 'banners/image');
    }

    public function video() {
        return $this->hasOne('App\Models\Files', 'foreign_id', 'id')
                    ->where('foreign_table', 'banners')
                    ->where('directory', 'banners/video');
    }
}
