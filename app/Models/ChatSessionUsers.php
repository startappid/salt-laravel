<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Schema;
use App\Traits\UuidModel;
use App\Traits\ObservableModel;

class ChatSessionUsers extends Resources {
    use UuidModel;
    use ObservableModel;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $filters = [
        'default',
        'search',
        'fields',
        'relationship',
        'withtrashed',
        'orderby',
        // Fields table provinces
        'id',
        'session_id',
        'user_id'
    ];

    protected $rules = array(
        "session_id" => 'required|string',
        "user_id" => 'required|integer',
    );

    protected $auths = array (
        'index',
        'store',
        'show',
        'update',
        'patch',
        'destroy',
        'trash',
        'trashed',
        'restore',
        'delete',
        'import',
        'export',
        'report'
    );

    protected $structures = array();

    protected $forms = array();
    protected $searchable = array('user_id', 'session_id');
    protected $fillable = array('user_id', 'session_id');

    public function user() {
        return $this->belongsTo('App\Models\Users', 'user_id', 'id');
    }

    public function checkUsersSessionExist($participants = []) {
        $sessions = $this->groupBy('session_id')
                        ->whereIn('user_id', $participants)
                        ->selectRaw('COUNT(user_id) AS total, session_id')
                        ->first();

        if($sessions->count()) {
            return true;
        }
        return false;
    }

    public function usersSession($participants = []) {
        $sessions = $this->groupBy('session_id')
                        ->whereIn('user_id', $participants)
                        ->selectRaw('COUNT(user_id) AS total, session_id')
                        ->first();
        return $sessions;
    }

}
