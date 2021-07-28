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

    protected $structures = array();
    protected $searchable = array('filename', 'title', 'alt', 'description', 'ext', 'size', 'dimension_width', 'dimension_height', 'type');
}
