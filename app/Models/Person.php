<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Schema;
use App\Observers\Traits\Actorable;
class Person extends Resources {

    use Actorable;

    protected $table = 'person';

    protected $rules = array();

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
        "first_name" => [
            'name' => 'first_name',
            'label' => 'First Name',
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
        "last_name" => [
            'name' => 'last_name',
            'label' => 'Last Name',
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
        "phone" => [
            'name' => 'phone',
            'label' => 'Phone',
            'display' => false,
            'validation' => [
                'create' => 'nullable|string',
                'update' => 'nullable|string',
                'delete' => null,
            ],
            'primary' => false,
            'type' => 'text',
            'validated' => true,
            'nullable' => false,
            'note' => null
        ],
        "gender" => [
            'name' => 'gender',
            'label' => 'Gender',
            'display' => false,
            'validation' => [
                'create' => 'nullable|string',
                'update' => 'nullable|string',
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

    protected $searchable = array('first_name', 'last_name', 'phone', 'gender');

}
