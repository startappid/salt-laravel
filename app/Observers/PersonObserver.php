<?php

namespace App\Observers;

class PersonObserver extends Observer
{

    public function saving($model) {
        $model->setAttribute('first_name', strtoupper($model->first_name));
        $model->setAttribute('last_name', strtoupper($model->last_name));
    }
}
