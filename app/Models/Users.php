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
        'username' => [
            'create' => 'required|string|max:255|unique:users,username',
            'update' => 'required|string|max:255|unique:users,username,{id}',
            'delete' => null,
        ],
        'email' => [
            'create' => 'required|string|email|max:255|unique:users,email',
            'update' => 'required|string|email|max:255|unique:users,email,{id}',
            'delete' => null,
        ],
        'first_name' => 'required|string|max:50',
        'last_name' => 'required|string|max:50',
        'password' => 'required|string|min:6|confirmed',
        'password_confirmation' => 'required_with:password|same:password|min:6',
        'gender' => 'required|string|in:male,female',
        'phone' => 'nullable|string',
        'photo' => 'mimes:jpeg,jpg,png|max:1024|nullable',
        'status' => 'required|string|in:inactive,active'
    );

    protected $forms = array();
    protected $structures = array();

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
