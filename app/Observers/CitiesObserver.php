<?php

namespace App\Observers;

use App\Models\Countries;
use App\Models\Provinces;

class CitiesObserver extends Observer
{

    // public function creating($model) {
    //     $country = Countries::find($model->country_id);
    //     $model->setAttribute('country', $country);

    //     $province = Provinces::find($model->province_id);
    //     $model->setAttribute('province', $province);
    // }

    // public function updating($model) {
    //     if($model->isDirty('country_id')) {
    //         $country = Countries::find($model->country_id);
    //         $model->setAttribute('country', $country);
    //     }

    //     if($model->isDirty('province_id')) {
    //         $province = Provinces::find($model->province_id);
    //         $model->setAttribute('province', $province);
    //     }
    // }

}
