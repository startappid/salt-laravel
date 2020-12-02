<?php

namespace App\Observers\Traits;
use Illuminate\Support\Facades\Auth;
use App\Models\Files;

trait Fileable
{
    protected $filebleType = 'compress';
    protected $filebleFields = [];

    /**
     * Boot the trait
     *
     * @return void
     */
    public static function bootImageable()
    {
        static::creating(function($model) {
            foreach (self::$filebleFields as $field) {
                $dataImage = array();
                // Check attributes if file type then stored to disk
                if(request()->hasFile($field)) {
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

                    $dataImage['type'] = self::$filebleType;
                }
                $image = Images::create($dataImage);
                $model->setAttribute($field, $image->id);
            }
        });

        static::updating(function($model) {
            foreach (self::$filebleFields as $field) {
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
                    $dataImage['type'] = self::$filebleType;
                }
                $image = Images::create($dataImage);
                // NOTE: Is it necessecery to delete previous image?
                $imagePrev = Images::find($model->getOriginal($field));
                $imagePrev->delete();

                $model->setAttribute($field, $image->id);
            }
        });
    }
}
