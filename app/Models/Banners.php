<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Schema;
use App\Observers\Traits\Fileable;

class Banners extends Resources {

    use Fileable;
    protected $fileableFields = ['video', 'banner'];
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

    protected $rules = array();

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

    protected $structures = array(
        "id" => [
            'name' => 'id',
            'default' => null,
            'label' => 'ID',
            'display' => false,
            'validation' => [
                'create' => null,
                'update' => null,
                'delete' => null,
            ],
            'primary' => true,
            'required' => true,
            'type' => 'integer',
            'validated' => false,
            'nullable' => false,
            'note' => null
        ],
        "title" => [
            'name' => 'title',
            'default' => null,
            'label' => 'Title',
            'display' => true,
            'validation' => [
                'create' => 'required|string',
                'update' => 'required|string',
                'delete' => null,
            ],
            'primary' => false,
            'required' => true,
            'type' => 'text',
            'validated' => true,
            'nullable' => false,
            'note' => null,
            'placeholder' => null,
        ],
        "description" => [
            'name' => 'description',
            'default' => null,
            'label' => 'Description',
            'display' => true,
            'validation' => [
                'create' => 'required|string',
                'update' => 'required|string',
                'delete' => null,
            ],
            'primary' => false,
            'required' => true,
            'type' => 'text',
            'validated' => true,
            'nullable' => false,
            'note' => null,
            'placeholder' => null,
        ],
        "status" => [
            'name' => 'status',
            'default' => null,
            'label' => 'Status',
            'display' => true,
            'validation' => [
                'create' => 'nullable|string',
                'update' => 'nullable|string',
                'delete' => null,
            ],
            'primary' => false,
            'required' => true,
            'type' => 'text',
            'validated' => true,
            'nullable' => false,
            'note' => null,
            'placeholder' => null,
        ],
        "type" => [
            'name' => 'type',
            'default' => null,
            'label' => 'Type',
            'display' => true,
            'validation' => [
                'create' => 'nullable|string',
                'update' => 'nullable|string',
                'delete' => null,
            ],
            'primary' => false,
            'required' => true,
            'type' => 'text',
            'validated' => true,
            'nullable' => false,
            'note' => null,
            'placeholder' => null,
        ],
        "videourl" => [
            'name' => 'videourl',
            'default' => null,
            'label' => 'Video URL',
            'display' => true,
            'validation' => [
                'create' => 'nullable|string',
                'update' => 'nullable|string',
                'delete' => null,
            ],
            'primary' => false,
            'required' => true,
            'type' => 'text',
            'validated' => true,
            'nullable' => false,
            'note' => null,
            'placeholder' => null,
        ],
        "order" => [
            'name' => 'order',
            'default' => null,
            'label' => 'Order',
            'display' => true,
            'validation' => [
                'create' => 'required|integer',
                'update' => 'required|integer',
                'delete' => null,
            ],
            'primary' => false,
            'required' => true,
            'type' => 'text',
            'validated' => true,
            'nullable' => false,
            'note' => null,
            'placeholder' => null,
        ],

        "created_at" => [
            'name' => 'created_at',
            'default' => null,
            'label' => 'Created At',
            'display' => false,
            'validation' => [
                'create' => null,
                'update' => null,
                'delete' => null,
            ],
            'primary' => false,
            'required' => false,
            'type' => 'datetime',
            'validated' => false,
            'nullable' => false,
            'note' => null
        ],
        "updated_at" => [
            'name' => 'updated_at',
            'default' => null,
            'label' => 'Updated At',
            'display' => false,
            'validation' => [
                'create' => null,
                'update' => null,
                'delete' => null,
            ],
            'primary' => false,
            'required' => false,
            'type' => 'datetime',
            'validated' => false,
            'nullable' => false,
            'note' => null
        ],
        "deleted_at" => [
            'name' => 'deleted_at',
            'default' => null,
            'label' => 'Deleted At',
            'display' => false,
            'validation' => [
                'create' => null,
                'update' => null,
                'delete' => null,
            ],
            'primary' => false,
            'required' => false,
            'type' => 'datetime',
            'validated' => false,
            'nullable' => false,
            'note' => null
        ]
    );

    protected $forms = array();
    protected $searchable = array( 'title', 'description', 'status', 'type','videourl','order');
    protected $fillable = array( 'title', 'description', 'status', 'type','videourl','order');

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
