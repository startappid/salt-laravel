<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Schema;
use App\Traits\UuidModel;
use Illuminate\Support\Arr;

// use App\Models\ChatSessionUsers;

class Chats extends Resources {
    use UuidModel;

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

    protected $rules = array();

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

    protected $structures = array(
        "id" => [
            'name' => 'id',
            'default' => null,
            'label' => 'ID',
            'display' => false,
            'validation' => [
                'create' => null,
                'update' => null,
                'delete' => null,
            ],
            'primary' => true,
            'required' => true,
            'type' => 'integer',
            'validated' => false,
            'nullable' => false,
            'note' => null
        ],
        "session_id" => [
            'name' => 'session_id',
            'default' => null,
            'label' => 'Session ID',
            'display' => true,
            'validation' => [
                'create' => 'required|string',
                'update' => 'required|string',
                'delete' => null,
            ],
            'primary' => false,
            'required' => true,
            'type' => 'text',
            'validated' => true,
            'nullable' => false,
            'note' => null,
            'placeholder' => null,
        ],
        "message_id" => [
            'name' => 'message_id',
            'default' => null,
            'label' => 'Message ID',
            'display' => true,
            'validation' => [
                'create' => 'required|string',
                'update' => 'required|string',
                'delete' => null,
            ],
            'primary' => false,
            'required' => true,
            'type' => 'text',
            'validated' => true,
            'nullable' => false,
            'note' => null,
            'placeholder' => null,
        ],
        "user_id" => [
            'name' => 'user_id',
            'default' => null,
            'label' => 'User ID',
            'display' => true,
            'validation' => [
                'create' => 'required|integer',
                'update' => 'required|integer',
                'delete' => null,
            ],
            'primary' => false,
            'required' => true,
            'type' => 'text',
            'validated' => true,
            'nullable' => false,
            'note' => null,
            'placeholder' => null,
        ],
        "read_at" => [
            'name' => 'read_at',
            'default' => null,
            'label' => 'Read At',
            'display' => true,
            'validation' => [
                'create' => 'nullable|datetime',
                'update' => 'nullable|datetime',
                'delete' => null,
            ],
            'primary' => false,
            'required' => true,
            'type' => 'text',
            'validated' => true,
            'nullable' => false,
            'note' => null,
            'placeholder' => null,
        ],

        "created_at" => [
            'name' => 'created_at',
            'default' => null,
            'label' => 'Created At',
            'display' => false,
            'validation' => [
                'create' => null,
                'update' => null,
                'delete' => null,
            ],
            'primary' => false,
            'required' => false,
            'type' => 'datetime',
            'validated' => false,
            'nullable' => false,
            'note' => null
        ],
        "updated_at" => [
            'name' => 'updated_at',
            'default' => null,
            'label' => 'Updated At',
            'display' => false,
            'validation' => [
                'create' => null,
                'update' => null,
                'delete' => null,
            ],
            'primary' => false,
            'required' => false,
            'type' => 'datetime',
            'validated' => false,
            'nullable' => false,
            'note' => null
        ],
        "deleted_at" => [
            'name' => 'deleted_at',
            'default' => null,
            'label' => 'Deleted At',
            'display' => false,
            'validation' => [
                'create' => null,
                'update' => null,
                'delete' => null,
            ],
            'primary' => false,
            'required' => false,
            'type' => 'datetime',
            'validated' => false,
            'nullable' => false,
            'note' => null
        ]
    );

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
