<?php

namespace App\Http\Controllers;

use App\Models\Permissions;
use App\Models\RoleHasPermissions;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RolesController extends ResourcesController
{
    public function editRoles(Request $request, $id = null)
    {
        if (!$this->model) abort(404);
        try {
            $data = $this->model->findOrFail($id);
            $this->setTitle(Str::title(Str::singular($this->table_name)));

            if (file_exists(resource_path('views/' . $this->table_name . '/edit.blade.php'))) {
                $this->view = view($this->table_name . '.edit');
            } else {
                $this->view = view('resources.edit');
            }

            $roles = DB::table('role_has_permissions')->get()->where('role_id', $id);

            $rolePermission = array();

            foreach($roles as $value){
                $rolePermission[] = $value->permission_id;
            }

            foreach ($this->structures as $key => $item) {
                $this->structures[$key]['value'] = $data->{$item['name']};
            }
            $forms = $this->model->getForms();
            return $this->view->with($this->respondWithData(array(
                'data' => $data,
                'forms' => $forms,
                'roles' => $rolePermission
            )));
        } catch (Exception $e) {
            throw $e->getMessage();
        }
    }
}
