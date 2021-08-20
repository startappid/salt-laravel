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
     * protected $fileableDirs = [
     *     'thumbnail' => 'directory/thumbnail',
     *     'gallery' => 'directory/gallery'
     * ];
     * protected $fileableForeignTable = null;
     * protected $fileableForeignId = null;
     *
     * NOTE: Casecade could be 2 forms, boolean and array
     * protected $fileableCascade = false;
     * protected $fileableCascade = [
     *     'thumbnail' => true,
     *     'gallery' => false
     * ];
     *
     */
    public $fileableEnabled = true;

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
            $fileableDirs = isset($model->fileableDirs)? $model->fileableDirs: ['file' => 'files'];

            foreach ($fileableFields as $field) {

                if(!request()->hasFile($field)) continue;

                $data = array();
                // Check attributes if file type then stored to disk
                $dir = request()->get('directory', null);
                if(is_null($dir)) {
                    $dir = isset($fileableDirs[$field])? $fileableDirs[$field]: 'files';
                }

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
                    $path = $file->storeAs("public/{$dir}", $filename);
                    $data['fullpath'] = url(str_replace('public', 'storage', $path));
                    $data['path'] = $path;
                }
                $data['directory'] = $dir;
                $data['type'] = $fileableType;

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
            if(!count($model->fileableFiles)) return;
            foreach ($model->fileableFiles as $data) {
                $data['foreign_table'] = $model->getTable();
                $data['foreign_id'] = $model->id;
                $file = Files::create($data);
            }
        });

        static::updating(function($model) {
            $selfFileable = isset($model->selfFileable)?: false;
            $fileableFields = isset($model->fileableFields)? $model->fileableFields: ['file'];
            $fileableType = isset($model->fileableType)? $model->fileableType: 'compress';
            $fileableDirs = isset($model->fileableDirs)? $model->fileableDirs: ['file' => 'files'];

            foreach ($fileableFields as $field) {

                if(!request()->hasFile($field)) continue;

                $data = array();
                // Check attributes if file type then stored to disk
                $dir = request()->get('directory', null);
                if(is_null($dir)) {
                    $dir = isset($fileableDirs[$field])? $fileableDirs[$field]: 'files';
                }

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
                    $path = $file->storeAs("public/{$dir}", $filename);
                    $data['fullpath'] = url(str_replace('public', 'storage', $path));
                    $data['path'] = $path;
                }
                $data['directory'] = $dir;
                $data['type'] = $fileableType;

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

        static::updated(function($model) {
            if(!count($model->fileableFiles)) return;
            $fileableCascade = isset($model->fileableCascade)?: false;
            foreach ($model->fileableFiles as $data) {
                $data['foreign_table'] = $model->getTable();
                $data['foreign_id'] = $model->id;
                $isCascade = $fileableCascade;
                if(!is_null($data['directory']) && isset($model->fileableCascade) && is_array($model->fileableCascade)) {
                    $key = array_search($data['directory'], $model->fileableDirs);
                    $isCascade = $model->fileableCascade[$key];
                }
                if($isCascade) {
                    Files::updateOrCreate(
                        [
                            'foreign_table' => $data['foreign_table'],
                            'foreign_id' => $data['foreign_id'],
                            'directory' => $data['directory']
                        ],
                        $data
                    );
                } else {
                    $file = Files::create($data);
                }
            }
        });

        static::restored(function($model) {
            $fileableCascade = isset($model->fileableCascade)?: false;
            if(!$fileableCascade) return;
            Files::withTrashed()
                ->where('foreign_table', $model->getTable())
                ->where('foreign_table', $model->id)
                ->restore();
        });

        static::deleted(function($model) {
            $fileableCascade = isset($model->fileableCascade)?: false;
            if(!$fileableCascade) return;
            Files::where('foreign_table', $model->getTable())
                ->where('foreign_table', $model->id)
                ->delete();
        });

        static::forceDeleted(function($model) {
            $fileableCascade = isset($model->fileableCascade)?: false;
            if(!$fileableCascade) return;
            Files::withTrashed()
                ->where('foreign_table', $model->getTable())
                ->where('foreign_table', $model->id)
                ->forceDelete();
        });

    }
}
