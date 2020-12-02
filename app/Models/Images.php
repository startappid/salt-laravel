<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Schema;

class Images extends Resources {

    protected $rules = array(
        'file' => 'required|image',
        'fullpath' => 'nullable|string|max:255',
        'path' => 'nullable|string|max:255',
        'filename' => 'nullable|string|max:255',
        'title' => 'nullable|string|max:255',
        'alt' => 'nullable|string|max:255',
        'description' => 'nullable|string|max:255',
        'size' => 'nullable|integer',
        'dimension_width' => 'nullable|integer',
        'dimension_height' => 'nullable|integer',
        'ext' => 'nullable|string|max:20',
        'type' => 'required|string'
    );

    protected $structures = array(
        "id" => [
            'name' => 'id',
            'label' => 'ID',
            'display' => false,
            'validation' => [
                'create' => null,
                'update' => null,
                'delete' => null,
            ],
            'primary' => true,
            'type' => 'integer',
            'validated' => false,
            'nullable' => false,
            'note' => null
        ],
        "file" => [
            'name' => 'file',
            'label' => 'Image',
            'display' => false,
            'validation' => [
                'create' => 'required|image',
                'update' => 'nullable|image',
                'delete' => null,
            ],
            'primary' => false,
            'type' => 'text',
            'validated' => true,
            'nullable' => false,
            'note' => null
        ],
        "fullpath" => [
            'name' => 'fullpath',
            'label' => 'Fullpath',
            'display' => false,
            'validation' => [
                'create' => 'nullable|string|max:255',
                'update' => 'nullable|string|max:255',
                'delete' => null,
            ],
            'primary' => false,
            'type' => 'text',
            'validated' => true,
            'nullable' => false,
            'note' => null
        ],
        "path" => [
            'name' => 'path',
            'label' => 'Path',
            'display' => false,
            'validation' => [
                'create' => 'nullable|string|max:255',
                'update' => 'nullable|string|max:255',
                'delete' => null,
            ],
            'primary' => false,
            'type' => 'text',
            'validated' => true,
            'nullable' => false,
            'note' => null
        ],
        "filename" => [
            'name' => 'filename',
            'label' => 'Filename',
            'display' => false,
            'validation' => [
                'create' => 'nullable|string|max:255',
                'update' => 'nullable|string|max:255',
                'delete' => null,
            ],
            'primary' => false,
            'type' => 'text',
            'validated' => true,
            'nullable' => false,
            'note' => null
        ],
        "title" => [
            'name' => 'title',
            'label' => 'Title',
            'display' => false,
            'validation' => [
                'create' => 'nullable|string|max:255',
                'update' => 'nullable|string|max:255',
                'delete' => null,
            ],
            'primary' => false,
            'type' => 'text',
            'validated' => true,
            'nullable' => false,
            'note' => null
        ],
        "alt" => [
            'name' => 'alt',
            'label' => 'Alternative',
            'display' => false,
            'validation' => [
                'create' => 'nullable|string|max:255',
                'update' => 'nullable|string|max:255',
                'delete' => null,
            ],
            'primary' => false,
            'type' => 'text',
            'validated' => true,
            'nullable' => false,
            'note' => null
        ],
        "description" => [
            'name' => 'description',
            'label' => 'Description',
            'display' => false,
            'validation' => [
                'create' => 'nullable|string|max:1024',
                'update' => 'nullable|string|max:1024',
                'delete' => null,
            ],
            'primary' => false,
            'type' => 'text',
            'validated' => true,
            'nullable' => false,
            'note' => null
        ],
        "ext" => [
            'name' => 'ext',
            'label' => 'Extension',
            'display' => false,
            'validation' => [
                'create' => 'nullable|string|max:20',
                'update' => 'nullable|string|max:20',
                'delete' => null,
            ],
            'primary' => false,
            'type' => 'text',
            'validated' => true,
            'nullable' => false,
            'note' => null
        ],
        "size" => [
            'name' => 'size',
            'label' => 'Size',
            'display' => false,
            'validation' => [
                'create' => 'nullable|integer',
                'update' => 'nullable|integer',
                'delete' => null,
            ],
            'primary' => false,
            'type' => 'text',
            'validated' => true,
            'nullable' => false,
            'note' => null
        ],
        "dimension_width" => [
            'name' => 'dimension_width',
            'label' => 'Width',
            'display' => false,
            'validation' => [
                'create' => 'nullable|integer',
                'update' => 'nullable|integer',
                'delete' => null,
            ],
            'primary' => false,
            'type' => 'text',
            'validated' => true,
            'nullable' => false,
            'note' => null
        ],
        "dimension_height" => [
            'name' => 'dimension_height',
            'label' => 'Height',
            'display' => false,
            'validation' => [
                'create' => 'nullable|integer',
                'update' => 'nullable|integer',
                'delete' => null,
            ],
            'primary' => false,
            'type' => 'text',
            'validated' => true,
            'nullable' => false,
            'note' => null
        ],
        "type" => [
            'name' => 'type',
            'label' => 'Type',
            'display' => false,
            'validation' => [
                'create' => 'required|string',
                'update' => 'required|string',
                'delete' => null,
            ],
            'primary' => false,
            'type' => 'text',
            'validated' => true,
            'nullable' => false,
            'note' => null
        ],
        "created_at" => [
            'name' => 'created_at',
            'label' => 'Created At',
            'display' => false,
            'validation' => [
                'create' => null,
                'update' => null,
                'delete' => null,
            ],
            'primary' => false,
            'type' => 'datetime',
            'validated' => false,
            'nullable' => false,
            'note' => null
        ],
        "updated_at" => [
            'name' => 'updated_at',
            'label' => 'Updated At',
            'display' => false,
            'validation' => [
                'create' => null,
                'update' => null,
                'delete' => null,
            ],
            'primary' => false,
            'type' => 'datetime',
            'validated' => false,
            'nullable' => false,
            'note' => null
        ],
        "deleted_at" => [
            'name' => 'deleted_at',
            'label' => 'Deleted At',
            'display' => false,
            'validation' => [
                'create' => null,
                'update' => null,
                'delete' => null,
            ],
            'primary' => false,
            'type' => 'datetime',
            'validated' => false,
            'nullable' => false,
            'note' => null
        ]
    );

    protected $searchable = array('filename', 'title', 'alt', 'description', 'ext', 'size', 'dimension_width', 'dimension_height', 'type');
}
