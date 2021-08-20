<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Resources;
use Spatie\Permission\Exceptions\UnauthorizedException;
use App\Services\ResponseService;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\ChatSessions;
use App\Models\ChatSessionUsers;
use App\Models\ChatMessages;
use App\Models\Chats;
use App\Models\Users;
use App\Models\User;
use Ramsey\Uuid\Uuid;

class SysparamsResourcesController extends ApiResourcesController
{

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getGroupNames(Request $request)
    {
        if(is_null($this->model)) {
            $this->responder->set('message', "Model not found!");
            $this->responder->setStatus(404, 'Not found.');
            return $this->responder->response();
        }

        try {
            $this->checkPermissions('show', 'read');
        } catch (\Exception $e) {
            $this->responder->set('message', 'You do not have authorization.');
            $this->responder->setStatus(401, 'Unauthorized');
            return $this->responder->response();
        }

        try {
            $data = $this->model
                        ->select('group')
                        ->groupBy('group')
                        ->get();

            if(is_null($data)) {
                $this->responder->set('message', 'Data not found');
                $this->responder->setStatus(404, 'Not Found');
                return $this->responder->response();
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
}
