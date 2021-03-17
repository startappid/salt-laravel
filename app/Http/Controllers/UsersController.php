<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UsersController extends ResourcesController
{
  public function role(Request $request, $id = null)
  {
    if (!$this->model) abort(404);

    try {
      $data = User::findOrFail($id);
      $user = Auth::user();

      
      if (!$user->hasRole(['superadmin'])) {
        return redirect('/'.$this->table_name)->with('info', 'tidak punya akses');
      }
      
      $role = $data->getRoleNames();
      
      $this->setTitle(Str::title(Str::singular($this->table_name)));
      
      $this->view = view($this->table_name.'.role');

      return $this->view->with($this->respondWithData(array(
        'data' => $data,
        'role' => $role->toArray(),
      )));
    } catch (Exception $e) {
      print_r($e);
    }
  }
}
