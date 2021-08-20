<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Schema;
use App\Traits\UuidModel;
use App\Traits\ObservableModel;

class ChatMessages extends Resources {
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
        'content',
        'type'
    ];

    protected $rules = array(
        "session_id" => 'required|string',
        "content" => 'required|string',
        "type" => 'nullable|string',
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
    protected $searchable = array('session_id', 'content', 'type');
    protected $fillable = array('session_id', 'content', 'type');

    public function chats(){
        return $this->hasMany(Chats::class, 'message_id', 'id');
    }

    public function createChat($session_id) {
        return $this->chats()->create([
            'session_id' => $session_id,
            'user_id' => auth()->id()]
        );
    }

}
