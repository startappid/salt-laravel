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

class UsersResourcesController extends ApiResourcesController
{

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id, $collection = null)
    {
        if(is_null($this->model)) {
            $this->responder->set('message', "Model not found!");
            $this->responder->setStatus(404, 'Not found.');
            return $this->responder->response();
        }

        // FIXME: this permission should be work
        // try {
        //     $this->checkPermissions('show', 'read');
        // } catch (\Exception $e) {
        //     $this->responder->set('message', 'You do not have authorization.');
        //     $this->responder->setStatus(401, 'Unauthorized');
        //     return $this->responder->response();
        // }

        try {
            $data = $this->model->filter()->find($id);
            if(is_null($data)) {
                $this->responder->set('message', 'Data not found');
                $this->responder->setStatus(404, 'Not Found');
                return $this->responder->response();
            }
            $user = User::find($id);
            $roles = $user->getRoleNames();
            $data->role = 'user';
            if(count($roles)) {
                $data->role = $roles[0];
            }

            $this->responder->set('message', 'Data retrieved');
            $this->responder->set('data', $data);
            return $this->responder->response();
        } catch(\Exception $e) {
            $this->responder->set('message', $e->getMessage());
            $this->responder->setStatus(500, 'Internal server error.');
            return $this->responder->response();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(Request $request, $id, Users $model)
    {
        // TODO: make this permission work in the future
        // try {
        //     $this->checkPermissions('update', 'update');
        // } catch (\Exception $e) {
        //     $this->responder->set('message', 'You do not have authorization.');
        //     $this->responder->setStatus(401, 'Unauthorized');
        //     return $this->responder->response();
        // }

        try {

            $user = $model::find($id);
            if(is_null($user)) {
                $this->responder->set('message', 'Data not found');
                $this->responder->setStatus(404, 'Not Found');
                return $this->responder->response();
            }

            $validator = Validator::make($request->all(), [
                                    'password' => 'required|min:6',
                                    'password_confirmation' => 'required|same:password'
                                ]);

            if ($validator->fails()) {
                $this->responder->set('errors', $validator->errors());
                $this->responder->set('message', $validator->errors()->first());
                $this->responder->setStatus(400, 'Bad Request.');
                return $this->responder->response();
            }

            $user->password = bcrypt($request->get('password'));
            $user->save();

            $this->responder->set('message', 'Password Changed.');
            $this->responder->set('data', $model);
            return $this->responder->response();
        } catch (\Exception $e) {
            $this->responder->set('message', $e->getMessage());
            $this->responder->setStatus(500, 'Internal server error.');
            return $this->responder->response();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     // FIXME: issue on observer Fileable and UserObserver
    public function updatePhoto(Request $request, $id, Files $file)
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

            $user = Users::find($id);
            if(is_null($user)) {
                $this->responder->set('message', 'Data not found');
                $this->responder->setStatus(404, 'Not Found');
                return $this->responder->response();
            }

            $validator = Validator::make($request->all(), [
                                    'file' => 'required|file'
                                ]);

            if ($validator->fails()) {
                $this->responder->set('errors', $validator->errors());
                $this->responder->set('message', $validator->errors()->first());
                $this->responder->setStatus(400, 'Bad Request.');
                return $this->responder->response();
            }

            $params = [
                'foreign_table' => 'users',
                'foreign_id' => $id,
                'directory' => 'users/profile',
                'type' => 'image'
            ];

            $model = $file
                        ->where($params)
                        ->first();

            if(is_null($model)) {
                $model = $file;
            }

            $data = Filestore::create($request->file('file'), $params);
            foreach ($data as $key => $value) {
                $model->setAttribute($key, $value);
            }
            $model->save();

            $this->responder->set('message', 'Photo updated.');
            $this->responder->set('data', $model);
            return $this->responder->response();

        } catch (\Exception $e) {
            $this->responder->set('message', $e->getMessage());
            $this->responder->setStatus(500, 'Internal server error.');
            return $this->responder->response();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getRoles(Request $request, $id, Users $model)
    {
        // TODO: make this permission allowed
        // try {
        //     $this->checkPermissions('getRoles', 'read');
        // } catch (\Exception $e) {
        //     $this->responder->set('message', 'You do not have authorization.');
        //     $this->responder->setStatus(401, 'Unauthorized');
        //     return $this->responder->response();
        // }

        try {
            $user = User::find($id);
            if(is_null($user)) {
                $this->responder->set('message', 'Data not found');
                $this->responder->setStatus(404, 'Not Found');
                return $this->responder->response();
            }

            $data = $user->getRoleNames();

            $this->responder->set('message', 'Roles fetched');
            $this->responder->set('data', $data);
            return $this->responder->response();
        } catch (\Exception $e) {
            $this->responder->set('message', $e->getMessage());
            $this->responder->setStatus(500, 'Internal server error.');
            return $this->responder->response();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateRoles(Request $request, $id, Users $model)
    {
        // TODO: make sure this authorization
        // try {
        //     $this->checkPermissions('patch', 'update');
        // } catch (\Exception $e) {
        //     $this->responder->set('message', 'You do not have authorization.');
        //     $this->responder->setStatus(401, 'Unauthorized');
        //     return $this->responder->response();
        // }

        try {

            $user = $model::find($id);
            if(is_null($user)) {
                $this->responder->set('message', 'Data not found');
                $this->responder->setStatus(404, 'Not Found');
                return $this->responder->response();
            }

            $validator = Validator::make($request->all(), [
                                    'roles' => 'required|array'
                                ]);

            if ($validator->fails()) {
                $this->responder->set('errors', $validator->errors());
                $this->responder->set('message', $validator->errors()->first());
                $this->responder->setStatus(400, 'Bad Request.');
                return $this->responder->response();
            }

            $user = User::find($id);
            $roles = $request->get('roles');
            $user->syncRoles($roles);

            $this->responder->set('message', 'Roles Changed.');
            $this->responder->set('data', $user);
            return $this->responder->response();
        } catch (\Exception $e) {
            $this->responder->set('message', $e->getMessage());
            $this->responder->setStatus(500, 'Internal server error.');
            return $this->responder->response();
        }
    }
}
