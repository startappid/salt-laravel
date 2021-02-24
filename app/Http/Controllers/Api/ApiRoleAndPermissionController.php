<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;

class ApiRoleAndPermissionController extends ApiResourcesController
{
    public function revokePermission(Request $request, $id)
    {
        $roles =  Role::find($id);
        $roles->revokePermissionTo($request['permission']);
        return response('roles deleted', 200);
    }

    public function givePermision(Request $request, $id)
    {
        $roles =  Role::find($id);
        $roles->givePermissionTo($request['permission']);
        return response('roles inserted', 200);
    }
}
