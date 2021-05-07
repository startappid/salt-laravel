<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Schema;
use App\Observers\UsersObserver as Observer;

class Users extends Resources {

    //  OBSERVER
    protected static function boot() {
        parent::boot();
        static::observe(Observer::class);
    }

    protected $rules = array(
        'username' => 'required|string|max:255|unique:users',
        'email' => 'required|string|email|max:255|unique:users',
        'first_name' => 'required|string|max:50',
        'last_name' => 'required|string|max:50',
        'password' => 'required|string|min:6|confirmed',
        'password_confirmation' => 'required_with:password|same:password|min:6',
        'gender' => 'integer|nullable',
        'phone' => 'nullable|string',
        'photo' => 'mimes:jpeg,jpg,png|max:1024|nullable',
        'is_active' => 'integer|nullable'
    );

    protected $forms = array(
        [
            [
                'class' => 'col-6',
                'field' => 'first_name'
            ],
            [
                'class' => 'col-6',
                'field' => 'last_name'
            ],
        ],
        [
            [
                'class' => 'col-6',
                'field' => 'username'
            ],
            [
                'class' => 'col-6',
                'field' => 'email'
            ],
        ],
        [
            [
                'class' => 'col-6',
                'field' => 'password'
            ],
            [
                'class' => 'col-6',
                'field' => 'password_confirmation'
            ],
        ],
        [
            [
                'class' => 'col-6',
                'field' => 'photo'
            ],
        ],
        [
            [
                'class' => 'col-6',
                'field' => 'gender'
            ],
            [
                'class' => 'col-6',
                'field' => 'phone'
            ],
        ],
        [
            [
                'class' => 'col-6',
                'field' => 'is_active'
            ],
        ],
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

        "first_name" => [
            'name' => 'first_name',
            'label' => 'Nama Depan',
            'display' => true,
            'validation' => [
                'create' => 'required|string|max:50',
                'update' => 'required|string|max:50',
                'delete' => null,
            ],
            'primary' => false,
            'required' => true,
            'type' => 'text',
            'validated' => true,
            'nullable' => false,
            'note' => null,
            'placeholder' => 'Nama Depan',
        ],

        "last_name" => [
            'name' => 'last_name',
            'label' => 'Nama Belakang',
            'display' => true,
            'validation' => [
                'create' => 'required|string|max:50',
                'update' => 'required|string|max:50',
                'delete' => null,
            ],
            'primary' => false,
            'required' => true,
            'type' => 'text',
            'validated' => true,
            'nullable' => false,
            'note' => null,
            'placeholder' => 'Last name',
        ],

        "username" => [
            'name' => 'username',
            'label' => 'Username',
            'display' => true,
            'validation' => [
                'create' => 'required|string|max:255|unique:users,username',
                'update' => 'required|string|max:255|unique:users,username,{id}',
                'delete' => null,
            ],
            'primary' => false,
            'required' => true,
            'type' => 'text',
            'validated' => true,
            'nullable' => false,
            'note' => null,
            'placeholder' => 'Username',
        ],

        "email" => [
            'name' => 'email',
            'label' => 'Email',
            'display' => true,
            'validation' => [
                'create' => 'required|string|email|max:255|unique:users,email',
                'update' => 'required|string|email|max:255|unique:users,email,{id}',
                'delete' => null,
            ],
            'primary' => false,
            'required' => true,
            'type' => 'text',
            'validated' => true,
            'nullable' => false,
            'note' => null,
            'placeholder' => 'Email',
        ],

        "password" => [
            'name' => 'password',
            'label' => 'Password',
            'display' => false,
            'validation' => [
                'create' => 'required|min:6',
                'update' => 'required|min:6',
                'delete' => null,
            ],
            'primary' => false,
            'required' => true,
            'type' => 'password',
            'validated' => true,
            'nullable' => false,
            'note' => null,
            'placeholder' => 'Password',
        ],

        "password_confirmation" => [
            'name' => 'password_confirmation',
            'label' => 'Password Confirmation',
            'display' => false,
            'validation' => [
                'create' => 'required|same:password',
                'update' => 'required|same:password',
                'delete' => null,
            ],
            'primary' => false,
            'required' => true,
            'type' => 'password',
            'validated' => true,
            'nullable' => false,
            'note' => null,
            'placeholder' => 'Password Confirmation',
        ],

        "gender" => [
            'name' => 'gender',
            'label' => 'Gender',
            'default' => null,
            'display' => true,
            'validation' => [
                'create' => 'string|nullable',
                'update' => 'string|nullable',
                'delete' => null,
            ],
            'primary' => false,
            'required' => false,
            'type' => 'radio',
            'validated' => true,
            'nullable' => false,
            'note' => null,
            'placeholder' => null,
            'inline' => true,
            'options' => [
                [
                    'value' => 'male',
                    'label' => 'Male'
                ],
                [
                    'value' => 'female',
                    'label' => 'Female'
                ],
            ],
            'options_disabled' => []
        ],

        "phone" => [
            'name' => 'phone',
            'label' => 'No. Telp',
            'display' => true,
            'validation' => [
                'create' => 'nullable|string',
                'update' => 'nullable|string',
                'delete' => null,
            ],
            'primary' => false,
            'required' => false,
            'type' => 'tel',
            'validated' => true,
            'nullable' => false,
            'note' => null,
            'placeholder' => 'No. Telp',
        ],

        "status" => [
            'name' => 'status',
            'default' => 'inactive',
            'label' => 'Status',
            'display' => false,
            'validation' => [
                'create' => 'integer|nullable',
                'update' => 'integer|nullable',
                'delete' => null,
            ],
            'primary' => false,
            'required' => false,
            'type' => 'radio',
            'validated' => true,
            'nullable' => false,
            'note' => null,
            'placeholder' => null,
            'inline' => true,
            'options' => [
                [
                    'value' => 'active',
                    'label' => 'Active'
                ],
                [
                    'value' => 'inactive',
                    'label' => 'No Active'
                ],
            ],
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

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password', 'first_name', 'last_name', 'api_token', 'phone', 'gender', 'driver_id', 'device_id', 'photo', 'is_active'
    ];

    protected $searchable = array('username',  'email', 'first_name', 'last_name', 'phone', 'status');

    public function photo() {
        return $this->belongsTo('App\Models\Files', 'foreign_id', 'id')->where('foreign_table', 'users');
    }

    public function address() {
        return $this->belongsTo('App\Models\Addresses', 'foreign_id', 'id')->where('foreign_table', 'users');
    }
}
