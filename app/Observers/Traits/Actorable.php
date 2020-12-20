<?php

namespace App\Observers\Traits;
use Illuminate\Support\Facades\Auth;

trait Actorable
{
    /**
     * Boot the trait
     *
     * @return void
     */
    public static function bootActorable()
    {
        static::creating(function($model) {
            $user = Auth::user();
            $model->setAttribute('created_by', $user->id);
        });

        static::updating(function($model) {
            $user = Auth::user();
            $model->setAttribute('updated_by', $user->id);
        });

        static::deleting(function($model) {
            $user = Auth::user();
            $model->setAttribute('deleted_by', $user->id);
        });

    }

    // public static function creating($model) {
    //     $user = Auth::user();
    //     $model->setAttribute('created_by', $user->id);
    // }

    // public static function updating($model) {
    //     $user = Auth::user();
    //     $model->setAttribute('updated_by', $user->id);
    // }

    // public static function deleting($model) {
    //     $user = Auth::user();
    //     $model->setAttribute('deleted_by', $user->id);
    // }
}
