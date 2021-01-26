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

        "username" => [
            'name' => 'username',
            'label' => 'Username',
            'display' => false,
            'validation' => [
                'create' => 'required|string|max:255|unique:users,username',
                'update' => 'required|string|max:255|unique:users,username,{id}',
                'delete' => null,
            ],
            'primary' => false,
            'type' => 'text',
            'validated' => true,
            'nullable' => false,
            'note' => null
        ],

        "email" => [
            'name' => 'email',
            'label' => 'Email',
            'display' => false,
            'validation' => [
                'create' => 'required|string|email|max:255|unique:users,username',
                'update' => 'required|string|email|max:255|unique:users,username,{id}',
                'delete' => null,
            ],
            'primary' => false,
            'type' => 'text',
            'validated' => true,
            'nullable' => false,
            'note' => null
        ],

        "first_name" => [
            'name' => 'first_name',
            'label' => 'First Name',
            'display' => false,
            'validation' => [
                'create' => 'required|string|max:50',
                'update' => 'required|string|max:50',
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
                'create' => 'required|string|max:50',
                'update' => 'required|string|max:50',
                'delete' => null,
            ],
            'primary' => false,
            'type' => 'text',
            'validated' => true,
            'nullable' => false,
            'note' => null
        ],

        "password" => [
            'name' => 'password',
            'label' => 'Password',
            'display' => false,
            'validation' => [
                'create' => 'required|string|min:6|confirmed',
                'update' => 'nullable|string|min:6|confirmed',
                'delete' => null,
            ],
            'primary' => false,
            'type' => 'text',
            'validated' => true,
            'nullable' => false,
            'note' => null
        ],

        "password_confirmation" => [
            'name' => 'password_confirmation',
            'label' => 'Password Confirmation',
            'display' => false,
            'validation' => [
                'create' => 'required_with:password|same:password|min:6',
                'update' => 'required_with:password|same:password|min:6',
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
                'create' => 'integer|nullable',
                'update' => 'integer|nullable',
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

        "photo" => [
            'name' => 'photo',
            'label' => 'Photo',
            'display' => false,
            'validation' => [
                'create' => 'mimes:jpeg,jpg,png|max:1024|nullable',
                'update' => 'mimes:jpeg,jpg,png|max:1024|nullable',
                'delete' => null,
            ],
            'primary' => false,
            'type' => 'text',
            'validated' => true,
            'nullable' => false,
            'note' => null
        ],

        "is_active" => [
            'name' => 'is_active',
            'label' => 'Active',
            'display' => false,
            'validation' => [
                'create' => 'integer|nullable',
                'update' => 'integer|nullable',
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

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password', 'first_name', 'last_name', 'api_token', 'phone', 'gender', 'driver_id', 'device_id', 'photo', 'is_active'
    ];

    protected $searchable = array('username',  'email', 'first_name', 'last_name', 'phone', 'status');

}
