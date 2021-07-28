<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Schema;

class Permissions extends Resources
{
    protected $table = 'permissions';
    protected $rules = array(
        "name" => 'required|string',
        "guard_name" => 'required|string',
    );

    protected $forms = array();
    protected $structures = array();

    protected $searchable = array('name', 'guard_name');
    protected $fillable = array('name', 'guard_name');

}
