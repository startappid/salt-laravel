<?php

namespace App\Observers;
use Illuminate\Support\Facades\Storage;
class Observer
{

  /** Observer life cycle
   * retrieved : after a record has been retrieved.
   * creating : before a record has been created.
   * created : after a record has been created.
   * updating : before a record is updated.
   * updated : after a record has been updated.
   * saving : before a record is saved (either created or updated).
   * saved : after a record has been saved (either created or updated).
   * deleting : before a record is deleted or soft-deleted.
   * deleted : after a record has been deleted or soft-deleted.
   * restoring : before a soft-deleted record is going to be restored.
   * restored : after a soft-deleted record has been restored.
  */

    public function retrieved($model) {

    }

    public function creating($model) {

    }

    public function created($model) {

    }

    public function updating($model) {

    }

    public function updated($model) {

    }

    public function saving($model) {
    //   foreach ($model->getAttributes() as $key => $value) {
    //     // Check attributes if file type then stored to disk
    //     if(request()->hasFile($key)) {
    //       $file = request()->file($key);
    //       $filename = uniqid().'-'.time().'.'.$file->getClientOriginalExtension();
    //       if(env('FILESYSTEM_DRIVER', 'local') == 'gcs') {
    //         $disk = Storage::disk('gcs');
    //         $path = $disk->put($model->getTable().'/'.$key, $file);
    //         $imgurl = ['https://storage.googleapis.com', env('GOOGLE_CLOUD_STORAGE_BUCKET'), $path];
    //         $model->setAttribute($key, implode('/', $imgurl));
    //       } else { // local
    //         $path = $file->storeAs($model->getTable().'/'.$key, $filename);
    //         $model->setAttribute($key, url('storage/app/'.$path));
    //       }
    //     }
    //   }
    }

    public function saved($model) {

    }

    public function restoring($model) {

    }

    public function restored($model) {

    }

    public function deleting($model) {

    }

    public function deleted($model) {

    }

    public function forceDeleted($model) {

    }
}
