<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use SaltLaravel\Traits\Uuids;

class Tokens extends Resources
{
    use Uuids;
    use SoftDeletes;

    protected $rules = array (
        'user_id' => 'required|integer',
        'token' => 'required|string|max:1024',
        'secret' => 'nullable|string|max:1024',
    );

    protected $fillable = ['user_id', 'token'];
    protected $hidden = [];
    protected $dates = ['deleted_at'];

}
