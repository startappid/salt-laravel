<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class UserFcmTokens extends Resources
{
    use SoftDeletes;

    protected $rules = array (
        'user_id' => 'required|integer',
        'token' => 'required|string|max:255',
    );

    protected $fillable = ['user_id', 'token'];
    protected $hidden = [];
    protected $dates = ['deleted_at'];

}
