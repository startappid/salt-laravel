<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Schema;
use App\Traits\ObservableModel;

class Notifications extends Resources {
    use ObservableModel;
    protected $keyType = 'string';

    protected $filters = [
        'default',
        'search',
        'fields',
        'relationship',
        'withtrashed',
        'orderby',
        // Fields table notifications
        'id',
        'type',
        'notifiable_type',
        'notifiable_id',
        'data',
        'read_at'
    ];

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
        'markAsRead',
        'markAsUnread',
        'markAllRead'
    );

    protected $rules = array(
        "type" => 'required|string',
        "notifiable_type" => 'required|string',
        "notifiable_id" => 'required|integer',
        "data" => 'required|string',
        "read_at" => 'nullable|timestamp',
    );
    protected $casts = [
        'data' => 'array',
    ];

    protected $forms = array();
    protected $structures = array();

    protected $searchable = array(
        'type',
        'notifiable_type',
        'notifiable_id',
        'data',
        'read_at'
    );

    protected $fillable = array(
        'type',
        'notifiable_type',
        'notifiable_id',
        'data',
        'read_at'
    );

    public function user() {
        return $this->belongsTo('App\Models\Users', 'notifiable_id', 'id')->withTrashed();
    }
}
