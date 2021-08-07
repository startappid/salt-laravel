<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Schema;
use App\Traits\UuidModel;
use App\Traits\ObservableModel;

class ChatSessions extends Resources {
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
        'type',
        'subject',
        'description'
    ];

    protected $rules = array(
        "type" => 'required|string',
        "subject" => 'nullable|string',
        "description" => 'nullable|string',
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
