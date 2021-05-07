<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Resources;
use App\Models\Roles;
use App\Models\Users;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Exceptions\UnauthorizedException;
use App\Services\ResponseService;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class RolesResourcesController extends ApiResourcesController
{

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getPermissions(Request $request, $id, Roles $model)
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
            $role = $model::find($id);
            if(is_null($role)) {
                $this->responder->set('message', 'Data not found');
                $this->responder->setStatus(404, 'Not Found');
                return $this->responder->response();
            }
            $permissions = Role::findByName($role->name)->permissions->pluck('name');
            $this->responder->set('message', 'Permissions fetched');
            $this->responder->set('data', $permissions);
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
    public function updatePermissions(Request $request, $id, Roles $model)
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

            $role = $model::find($id);
            if(is_null($role)) {
                $this->responder->set('message', 'Data not found');
                $this->responder->setStatus(404, 'Not Found');
                return $this->responder->response();
            }

            $validator = Validator::make($request->all(), [
                                    'permissions' => 'required|array'
                                ]);

            if ($validator->fails()) {
                $this->responder->set('errors', $validator->errors());
                $this->responder->set('message', $validator->errors()->first());
                $this->responder->setStatus(400, 'Bad Request.');
                return $this->responder->response();
            }
            $role = Role::findByName($role->name);
            $permissions = $request->get('permissions');
            $role->syncPermissions($permissions);
            $this->responder->set('message', 'Permissions Updated');
            $this->responder->set('data', $permissions);
            return $this->responder->response();
        } catch (\Exception $e) {
            $this->responder->set('message', $e->getMessage());
            $this->responder->setStatus(500, 'Internal server error.');
            return $this->responder->response();
        }
    }
}
