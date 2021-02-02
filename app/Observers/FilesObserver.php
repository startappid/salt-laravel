<?php

namespace App\Observers;

use Illuminate\Support\Facades\Storage;

class FilesObserver extends Observer
{
    public function creating($model) {
        $field = 'file';
        if(request()->hasFile($field)) {
            $file = request()->file($field);
            $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $filename = $filename.'-'.time().'.'.$file->getClientOriginalExtension();
            $model->setAttribute('filename', $filename);
            $model->setAttribute('ext', $file->getClientOriginalExtension());
            $model->setAttribute('size', $file->getSize());
            if(env('FILESYSTEM_DRIVER', 'local') == 'gcs') {
                $disk = Storage::disk('gcs');
                $path = $disk->put($model->getTable(), $file);
                $imgurl = ['https://storage.googleapis.com', env('GOOGLE_CLOUD_STORAGE_BUCKET'), $path];
                $model->setAttribute('fullpath', implode('/', $imgurl));
                $model->setAttribute('path', $path);
            } else { // local
                $path = $file->storeAs('public/'.$model->getTable(), $filename);
                $model->setAttribute('fullpath', url(str_replace('public', 'storage', $path)));
                $model->setAttribute('path', $path);
            }
        }
        request()->request->remove($field);
        unset(request()[$field]);
        unset($model[$field]);
    }

    public function updating($model) {
        $dataImage = array();
        $field = 'file';
        if(request()->hasFile($field) && $model->isDirty($field)) {
            $file = request()->file($field);
            $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $filename = $filename.'-'.time().'.'.$file->getClientOriginalExtension();
            $model->setAttribute('filename', $filename);
            $model->setAttribute('ext', $file->getClientOriginalExtension());
            $model->setAttribute('size', $file->getSize());
            if(env('FILESYSTEM_DRIVER', 'local') == 'gcs') {
                $disk = Storage::disk('gcs');
                $path = $disk->put($model->getTable(), $file);
                $imgurl = ['https://storage.googleapis.com', env('GOOGLE_CLOUD_STORAGE_BUCKET'), $path];
                $model->setAttribute('fullpath', implode('/', $imgurl));
                $model->setAttribute('path', $path);
            } else { // local
                $path = $file->storeAs('public/'.$model->getTable(), $filename);
                $model->setAttribute('fullpath', url(str_replace('public', 'storage', $path)));
                $model->setAttribute('path', $path);
            }
        }
        request()->request->remove($field);
        unset(request()[$field]);
        unset($model[$field]);
    }
}
