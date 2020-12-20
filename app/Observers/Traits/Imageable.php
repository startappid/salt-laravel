<?php

namespace App\Observers\Traits;
use App\Models\Images;

trait Imageable
{
    protected $imageableFields = [];
    protected $imageableType = 'image';

    /**
     * Boot the trait
     *
     * @return void
     */
    public static function bootImageable()
    {
        static::creating(function($model) {
            foreach (self::$imageableFields as $field) {
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
                    } else { // local
                        $path = $file->storeAs($model->getTable().'/'.$field, $filename);
                        $dataImage['fullpath'] = url('storage/app/'.$path);
                        $dataImage['path'] = $path;
                    }

                    $dimention = getimagesize($path);
                    $width = $dimention[0];
                    $height = $dimention[1];
                    $dataImage['dimension_width'] = $width;
                    $dataImage['dimension_height'] = $height;
                    $dataImage['type'] = self::$imageableType;
                }
                $image = Images::create($dataImage);
                $model->setAttribute($field, $image->id);
            }
        });

        static::updating(function($model) {
            foreach (self::$imageableFields as $field) {
                $dataImage = array();
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
                    $dimention = getimagesize($path);
                    $width = $dimention[0];
                    $height = $dimention[1];
                    $dataImage['dimension_width'] = $width;
                    $dataImage['dimension_height'] = $height;
                    $dataImage['type'] = self::$imageableType;
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
