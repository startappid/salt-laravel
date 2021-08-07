<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Schema;
use App\Traits\UuidModel;
use Illuminate\Support\Arr;
use App\Traits\ObservableModel;

class Chats extends Resources {
    use UuidModel;
    use ObservableModel;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $appends = ['ownership'];

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
        'message_id',
        'user_id',
        'read_at',
        'created_at'
    ];

    protected $rules = array(
        "session_id" => 'required|string',
        "message_id" => 'required|string',
        "user_id" => 'required|integer',
        "read_at" => 'nullable|datetime',
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
        'report',
        'getContacts',
        'getChatsHistory',
        'createSession',
        'getMessagesBySession',
        'createMessageBySession',
        'markChatsAsRead',
        'markChatsAsUnread',
        'clearChats',
        'blockUser',
        'unblockUser',
    );

    protected $structures = array();

    protected $forms = array();
    protected $searchable = array('session_id', 'message_id', 'user_id', 'read_at');
    protected $fillable = array('session_id', 'message_id', 'user_id', 'read_at');

    public function getOwnershipAttribute() {
        if($this->user_id == auth()->id()) return 'mine';
        return 'theirs';
    }

    public function message() {
        return $this->belongsTo('App\Models\ChatMessages', 'message_id', 'id');
    }

    public function user() {
        return $this->belongsTo('App\Models\Users', 'user_id', 'id');
    }

    public function userChatsHistory($user_id) {
        $chats = $this->with(['user', 'message'])
                        ->groupByRaw('session_id DESC')
                        ->having('user_id', $user_id)
                        ->get();
        return $chats;
    }

    public function userChatsHistoryBySession($user_id, $sessions_id) {

        $limit = intval(request()->get('limit', 25));
        if($limit > 100) {
            $limit = 100;
        }

        $p = intval(request()->get('page', 1));
        $page = ($p > 0 ? $p - 1: $p);

        $chats = $this->with(['user', 'message'])
                        ->filter()
                        ->offset($page * $limit)
                        ->limit($limit)
                        ->get();
        return $chats;
    }
}
