<?php

namespace App\Services;

use Illuminate\Http\Request;

class Filestore {

    /**
     * Return the remainder of a string after the first occurrence of a given value.
     *
     * @param  string  $subject
     * @param  string  $search
     * @return string
     */
    public static function create($file, $params = [])
    {
        $data = array_merge(array(
            'foreign_table' => null,
            'foreign_id' => null,
            'directory' => 'files'
        ), $params);

        // Check attributes if file type then stored to disk
        $dir = $data['directory'];

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

        return $data;
    }

}
