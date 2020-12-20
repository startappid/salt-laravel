<?php

namespace App\Observers;

use App\Models\Countries;

class ProvincesObserver extends Observer
{

    // public function creating($model) {
    //     $country = Countries::find($model->country_id);
    //     $model->setAttribute('country', $country);
    // }

    // public function updating($model) {
    //     if($model->isDirty('country_id')) {
    //         $country = Countries::find($model->country_id);
    //         $model->setAttribute('country', $country);
    //     }
    // }

}
