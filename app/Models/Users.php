<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Schema;
use App\Observers\UsersObserver as Observer;
use SaltLaravel\Traits\ObservableModel;
use SaltLaravel\Traits\Uuids;

class Users extends Resources {

    use Uuids;
    use ObservableModel;

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
        'password' => [
            'create' => 'required|string|min:6|confirmed',
            'update' => null,
            'delete' => null,
        ],
        'password_confirmation' => [
            'create' => 'required_with:password|same:password|min:6',
            'update' => null,
            'delete' => null,
        ],
        'gender' => 'required|string|in:male,female',
        'phone' => 'nullable|string',
        'bod' => 'nullable|date',
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
      'username',
      'email',
      'password',
      'password_confirmation',
      'gender',
      'phone',
      'bod',
      'status',
    ];

    protected $searchable = array(
      'username',
      'email',
      'password',
      'password_confirmation',
      'gender',
      'phone',
      'bod',
      'status',
    );

    protected $hidden = array('password', 'PIN');

    public function photo() {
        return $this->belongsTo('SaltFile\Models\Files', 'id', 'foreign_id')
                    ->where('foreign_table', 'users')
                    ->where('directory', 'users/profile');
    }

    public function address() {
        // FIXME: please fix this user address relation
        return $this->belongsTo('SaltContacts\Models\ContactAddresses', 'contact_id', 'id');
    }

    public function roles() {
        return $this->hasMany('App\Models\ModelHasRoles', 'model_id', 'id')->where('model_type', 'App\Models\User');
    }

    public function role($query, $value = 'user') {
        $roles = (array) $value;
        return $query
                    ->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
                    ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                    ->whereIn('roles.name', $roles)
                    ->select('users.*');
    }
}
