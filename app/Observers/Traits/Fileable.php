<?php

namespace App\Observers\Traits;
use Illuminate\Support\Facades\Auth;
use App\Models\Files;

trait Fileable
{
    /**
     *
     * protected $fileableType = 'compress';
     * protected $selfFileable = false;
     * protected $fileableFields = ['file'];
     * protected $fileableForeignTable = null;
     * protected $fileableForeignId = null;
     *
     */

    protected $fileableFiles = [];

    /**
     * Boot the trait
     *
     * @return void
     */
    public static function bootFileable()
    {
        static::creating(function($model) {
            $selfFileable = isset($model->selfFileable)?: false;
            $fileableFields = isset($model->fileableFields)? $model->fileableFields: ['file'];
            $fileableType = isset($model->fileableType)? $model->fileableType: 'compress';

            foreach ($fileableFields as $field) {
                $data = array();
                // Check attributes if file type then stored to disk
                if(request()->hasFile($field)) {
                    $file = request()->file($field);
                    $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                    $filename = $filename.'-'.time().'.'.$file->getClientOriginalExtension();
                    $data['filename'] = $filename;
                    $data['ext'] = $file->getClientOriginalExtension();
                    $data['size'] = $file->getSize();
                    if(env('FILESYSTEM_DRIVER', 'local') == 'gcs') {
                        $disk = Storage::disk('gcs');
                        $path = $disk->put($model->getTable(), $file);
                        $imgurl = ['https://storage.googleapis.com', env('GOOGLE_CLOUD_STORAGE_BUCKET'), $path];
                        $data['fullpath'] = implode('/', $imgurl);
                        $data['path'] = $path;
                    } else { // local
                        $path = $file->storeAs('public/files', $filename);
                        $data['fullpath'] = url(str_replace('public', 'storage', $path));
                        $data['path'] = $path;
                    }
                    $data['type'] = $fileableType;
                }
                request()->request->remove($field);
                unset(request()[$field]);
                unset($model[$field]);
                if($selfFileable == true) {
                    foreach ($data as $field => $value) {
                        $model->setAttribute($field, $value);
                    }
                } else {
                    $model->fileableFiles[] = $data;
                }
            }
        });

        static::created(function($model) {
            if(count($model->fileableFiles)) {
                foreach ($model->fileableFiles as $data) {
                    $data['foreign_table'] = $model->getTable();
                    $data['foreign_id'] = $model->id;
                    $file = Files::create($data);
                }
            }
        });

        static::updating(function($model) {
            foreach (self::$fileableFields as $field) {
                $dataImage = array();
                // Check attributes if file type then stored to disk
                if(request()->hasFile($field) && $model->isDirty($field)) {
                    $file = request()->file($field);
                    $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                    $filename = $filename.'-'.time().'.'.$file->getClientOriginalExtension();
                    $dataImage['filename'] = $filename;
                    $dataImage['ext'] = $file->getClientOriginalExtension();
                    $dataImage['size'] = $file->getSize();
                    if(env('FILESYSTEM_DRIVER', 'local') == 'gcs') {
                        $disk = Storage::disk('gcs');
                        $path = $disk->put($model->getTable().'/'.$field, $file);
                        $imgurl = ['https://storage.googleapis.com', env('GOOGLE_CLOUD_STORAGE_BUCKET'), $path];
                        $dataImage['fullpath'] = implode('/', $imgurl);
                        $dataImage['path'] = $path;
                        // $model->setAttribute($field, implode('/', $imgurl));
                    } else { // local
                        $path = $file->storeAs($model->getTable().'/'.$field, $filename);
                        $dataImage['fullpath'] = url('storage/app/'.$path);
                        $dataImage['path'] = $path;
                        // $model->setAttribute($field, url('storage/app/'.$path));
                    }
                    $dataImage['type'] = self::$fileableType;
                }
                $image = Files::create($dataImage);
                // NOTE: Is it necessecery to delete previous image?
                $imagePrev = Files::find($model->getOriginal($field));
                $imagePrev->delete();

                $model->setAttribute($field, $image->id);
            }
        });
    }
}
