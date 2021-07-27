<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Resources;
use App\Models\Users;
use App\Models\User;
use App\Models\Files;
use App\Services\Filestore;
use Spatie\Permission\Exceptions\UnauthorizedException;
use App\Services\ResponseService;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class FilesResourcesController extends ApiResourcesController
{

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function upCreate(Request $request)
    {
        // TODO: make this permission work in the future
        // try {
        //     $this->checkPermissions('updatePhoto', 'update');
        // } catch (\Exception $e) {
        //     $this->responder->set('message', 'You do not have authorization.');
        //     $this->responder->setStatus(401, 'Unauthorized');
        //     return $this->responder->response();
        // }

        try {

            $validator = Validator::make($request->all(), [
                                    'file' => 'required|file',
                                    'foreign_table' => 'required|string',
                                    'foreign_id' => 'required|integer',
                                    'directory' => 'required|string'
                                ]);

            if ($validator->fails()) {
                $this->responder->set('errors', $validator->errors());
                $this->responder->set('message', $validator->errors()->first());
                $this->responder->setStatus(400, 'Bad Request.');
                return $this->responder->response();
            }

            $model = $this->model
                        ->where($request->only([
                            'foreign_table',
                            'foreign_id',
                            'directory'
                        ]))
                        ->first();

            if(is_null($model)) {
                $model = $this->model;
            }

            $params = $request->only($this->model->getTableFields());
            $file = request()->file('file');
            $data = Filestore::create($file, $params);
            foreach ($data as $key => $value) {
                $model->setAttribute($key, $value);
            }
            $model->save();

            $this->responder->set('message', 'Data updated.');
            $this->responder->set('data', $model);
            return $this->responder->response();

        } catch (\Exception $e) {
            $this->responder->set('message', $e->getMessage());
            $this->responder->setStatus(500, 'Internal server error.');
            return $this->responder->response();
        }
    }
}
