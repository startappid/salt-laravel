<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Schema;

class Files extends Resources {

    protected $rules = array(
        'file' => 'required|file',
        'fullpath' => 'nullable|string|max:255',
        'path' => 'nullable|string|max:255',
        'filename' => 'nullable|string|max:255',
        'title' => 'nullable|string|max:255',
        'description' => 'nullable|string|max:255',
        'size' => 'nullable|integer',
        'ext' => 'nullable|string|max:20',
        'type' => 'required|string'
    );
    protected $forms = array(
        [
            [
                'class' => 'col-6',
                'field' => 'file'
            ],
            [
                'class' => 'col-2',
                'field' => 'type'
            ]
        ],
        [
            [
                'class' => 'col-4',
                'field' => 'title'
            ],
            [
                'class' => 'col-8',
                'field' => 'description'
            ]
        ]
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
            'label' => 'Pick your file',
            'display' => false,
            'validation' => [
                'create' => 'required|file',
                'update' => 'nullable|file',
                'delete' => null,
            ],
            'required' => true,
            'primary' => false,
            'type' => 'file',
            'validated' => true,
            'nullable' => false,
            'note' => null,
            'placeholder' => null,
        ],
        "foreign_table" => [
            'name' => 'foreign_table',
            'label' => 'Table name',
            'display' => false,
            'validation' => [
                'create' => 'nullable|string',
                'update' => 'nullable|string',
                'delete' => null,
            ],
            'required' => true,
            'primary' => false,
            'type' => 'text',
            'validated' => true,
            'nullable' => false,
            'note' => null,
            'placeholder' => null,
        ],
        "foreign_id" => [
            'name' => 'foreign_id',
            'label' => 'Table field',
            'display' => false,
            'validation' => [
                'create' => 'nullable|integer',
                'update' => 'nullable|integer',
                'delete' => null,
            ],
            'required' => true,
            'primary' => false,
            'type' => 'text',
            'validated' => true,
            'nullable' => false,
            'note' => null,
            'placeholder' => null,
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
            'required' => false,
            'primary' => false,
            'type' => 'text',
            'validated' => true,
            'nullable' => false,
            'note' => null,
            'placeholder' => null,
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
            'required' => false,
            'primary' => false,
            'type' => 'text',
            'validated' => true,
            'nullable' => false,
            'note' => null,
            'placeholder' => null,
        ],
        "filename" => [
            'name' => 'filename',
            'label' => 'Filename',
            'display' => true,
            'validation' => [
                'create' => 'nullable|string|max:255',
                'update' => 'nullable|string|max:255',
                'delete' => null,
            ],
            'required' => false,
            'primary' => false,
            'type' => 'text',
            'validated' => true,
            'nullable' => false,
            'note' => null,
            'placeholder' => null,
        ],
        "title" => [
            'name' => 'title',
            'label' => 'Title',
            'display' => true,
            'validation' => [
                'create' => 'nullable|string|max:255',
                'update' => 'nullable|string|max:255',
                'delete' => null,
            ],
            'required' => false,
            'primary' => false,
            'type' => 'text',
            'validated' => true,
            'nullable' => false,
            'note' => null,
            'placeholder' => null,
        ],
        "description" => [
            'name' => 'description',
            'label' => 'Description',
            'display' => true,
            'validation' => [
                'create' => 'nullable|string|max:1024',
                'update' => 'nullable|string|max:1024',
                'delete' => null,
            ],
            'required' => false,
            'primary' => false,
            'type' => 'text',
            'validated' => true,
            'nullable' => false,
            'note' => null,
            'placeholder' => null,
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
            'required' => false,
            'primary' => false,
            'type' => 'text',
            'validated' => true,
            'nullable' => false,
            'note' => null,
            'placeholder' => null,
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
            'required' => false,
            'primary' => false,
            'type' => 'text',
            'validated' => true,
            'nullable' => false,
            'note' => null,
            'placeholder' => null,
        ],
        "type" => [
            'name' => 'type',
            'label' => 'Type',
            'display' => true,
            'validation' => [
                'create' => 'nullable|string|max:100',
                'update' => 'nullable|string',
                'delete' => null,
            ],
            'required' => false,
            'primary' => false,
            'type' => 'select',
            'validated' => true,
            'nullable' => false,
            'note' => null,
            'placeholder' => null,
            // Options
            'default' => 'image',
            'inline' => false,
            'options' => [
                [
                    'value' => 'compress',
                    'label' => 'Compress'
                ],
                [
                    'value' => 'document',
                    'label' => 'Docs'
                ],
                [
                    'value' => 'image',
                    'label' => 'Image'
                ],
                [
                    'value' => 'other',
                    'label' => 'Other'
                ],
            ],
            // Options disabled according to value
            'options_disabled' => []
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

    protected $searchable = array('filename', 'title', 'description', 'ext', 'size', 'type');
}
