<?php

namespace App\Observers;
use Illuminate\Support\Facades\Auth;

class ActorableObserver
{

    public function creating($model) {
        $user = Auth::user();
        $model->setAttribute('created_by', $user->id);
    }

    public function updating($model) {
        $user = Auth::user();
        $model->setAttribute('updated_by', $user->id);
    }

    public function deleting($model) {
        $user = Auth::user();
        $model->setAttribute('deleted_by', $user->id);
    }
}
