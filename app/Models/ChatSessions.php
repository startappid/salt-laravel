<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Schema;
use App\Traits\UuidModel;

class ChatSessions extends Resources {
    use UuidModel;

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
        'type',
        'subject',
        'description'
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
        'report'
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
        "type" => [
            'name' => 'type',
            'default' => null,
            'label' => 'Type',
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
        "subject" => [
            'name' => 'subject',
            'default' => null,
            'label' => 'Subject',
            'display' => true,
            'validation' => [
                'create' => 'nullable|string',
                'update' => 'nullable|string',
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
        "description" => [
            'name' => 'description',
            'default' => null,
            'label' => 'Description',
            'display' => true,
            'validation' => [
                'create' => 'nullable|string',
                'update' => 'nullable|string',
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
    protected $searchable = array('type', 'subject', 'description');
    protected $fillable = array('type', 'subject', 'description');

    public function user() {
        return $this->belongsTo('App\Models\Users', 'user_id', 'id');
    }

    public function blocker() {
        return $this->belongsTo('App\Models\Users', 'blocked_by', 'id');
    }

    public function chats() {
        return $this->hasManyThrough(
            'App\Models\Chats',
            'App\Models\ChatMessages',
            'session_id',
            'session_id',
            'id',
            'id'
        );
    }

    public function messages() {
        return $this->hasMany('App\Models\ChatMessages', 'session_id', 'id');
    }

    public function users() {
        return $this->hasMany('App\Models\ChatSessionUsers', 'session_id', 'id');
    }

    public function deleteChats() {
        $this->chats()->where('user_id', auth()->id())->delete();
    }

    public function deleteMessages() {
        $this->messages()->delete();
    }

    public function block() {
        $this->is_blocked = true;
        $this->blocked_by = auth()->id();
        $this->save();
    }

    public function unblock() {
        $this->is_blocked = false;
        $this->blocked_by = null;
        $this->save();
    }
}
