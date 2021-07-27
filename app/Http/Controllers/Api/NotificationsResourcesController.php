<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Resources;
use App\Models\User;
use Spatie\Permission\Exceptions\UnauthorizedException;
use App\Services\ResponseService;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Notifications\AppNotification;

class NotificationsResourcesController extends ApiResourcesController
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

        try {
            $this->checkPermissions('show', 'read');
        } catch (\Exception $e) {
            $this->responder->set('message', 'You do not have authorization.');
            $this->responder->setStatus(401, 'Unauthorized');
            return $this->responder->response();
        }

        try {
            $data = $this->model->filter()->find($id);
            if(is_null($data)) {
                $this->responder->set('message', 'Data not found');
                $this->responder->setStatus(404, 'Not Found');
                return $this->responder->response();
            }
            if($data->notifiable_id == $request->user()->id) {
                $data->read_at = now();
                $data->save();
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function markAllRead(Request $request)
    {
        if(is_null($this->model)) {
            $this->responder->set('message', "Model not found!");
            $this->responder->setStatus(404, 'Not found.');
            return $this->responder->response();
        }

        try {
            $this->checkPermissions('markAllRead', 'read');
        } catch (\Exception $e) {
            $this->responder->set('message', 'You do not have authorization.');
            $this->responder->setStatus(401, 'Unauthorized');
            return $this->responder->response();
        }

        try {
            $this->model
                ->where('notifiable_id', $request->user()->id)
                ->where('read_at', null)
                ->update(['read_at' => now()]);

            $this->responder->set('message', 'Notifications mark as read');
            $this->responder->set('data', null);
            return $this->responder->response();
        } catch(\Exception $e) {
            $this->responder->set('message', $e->getMessage());
            $this->responder->setStatus(500, 'Internal server error.');
            return $this->responder->response();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function markAsRead(Request $request, $id)
    {
        if(is_null($this->model)) {
            $this->responder->set('message', "Model not found!");
            $this->responder->setStatus(404, 'Not found.');
            return $this->responder->response();
        }

        try {
            $this->checkPermissions('markAsRead', 'read');
        } catch (\Exception $e) {
            $this->responder->set('message', 'You do not have authorization.');
            $this->responder->setStatus(401, 'Unauthorized');
            return $this->responder->response();
        }

        try {
            $data = $this->model->filter()->find($id);
            if(is_null($data)) {
                $this->responder->set('message', 'Data not found');
                $this->responder->setStatus(404, 'Not Found');
                return $this->responder->response();
            }
            if($data->notifiable_id == $request->user()->id) {
                $data->read_at = now();
                $data->save();
            }
            $this->responder->set('message', 'Notification mark as read');
            $this->responder->set('data', $data);
            return $this->responder->response();
        } catch(\Exception $e) {
            $this->responder->set('message', $e->getMessage());
            $this->responder->setStatus(500, 'Internal server error.');
            return $this->responder->response();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function markAsUnread(Request $request, $id)
    {
        if(is_null($this->model)) {
            $this->responder->set('message', "Model not found!");
            $this->responder->setStatus(404, 'Not found.');
            return $this->responder->response();
        }

        try {
            $this->checkPermissions('markAsUnread', 'read');
        } catch (\Exception $e) {
            $this->responder->set('message', 'You do not have authorization.');
            $this->responder->setStatus(401, 'Unauthorized');
            return $this->responder->response();
        }

        try {
            $data = $this->model->filter()->find($id);
            if(is_null($data)) {
                $this->responder->set('message', 'Data not found');
                $this->responder->setStatus(404, 'Not Found');
                return $this->responder->response();
            }
            if($data->notifiable_id == $request->user()->id) {
                $data->read_at = null;
                $data->save();
            }
            $this->responder->set('message', 'Notification mark as unread');
            $this->responder->set('data', $data);
            return $this->responder->response();
        } catch(\Exception $e) {
            $this->responder->set('message', $e->getMessage());
            $this->responder->setStatus(500, 'Internal server error.');
            return $this->responder->response();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if(is_null($this->model)) {
            $this->responder->set('message', "Model not found!");
            $this->responder->setStatus(404, 'Not found.');
            return $this->responder->response();
        }

        // FIXME: issue about permission, this must be resolved ASAP
        // try {
        //     $this->checkPermissions('store', 'create');
        // } catch (\Exception $e) {
        //     $this->responder->set('message', 'You do not have authorization.');
        //     $this->responder->setStatus(401, 'Unauthorized');
        //     return $this->responder->response();
        // }

        try {
            $validator = Validator::make($request->all(), [
                'type' => [
                    'required',
                    'string',
                    Rule::in(['all', 'agent', 'student']),
                ],
                'users' => 'nullable|array',
                'excludes' => 'nullable|array',
                'subject' => 'required|string',
                'message' => 'required|string',
                'template' => 'nullable',
            ]);
            if ($validator->fails()) {
                $this->responder->set('errors', $validator->errors());
                $this->responder->set('message', $validator->errors()->first());
                $this->responder->setStatus(400, 'Bad Request.');
                return $this->responder->response();
            }

            $users_ids = $request->get('users');
            $excludes_ids = $request->get('excludes');
            $roles = ['agent', 'student'];
            if($request->get('type') !== 'all') {
                $roles = (array) $request->get('type');
            }

            $model = User::where('users.status', 'active')
                        ->where('users.membership_status', 1);

            if(!is_null($users_ids)) {
                $model = $model->whereIn('users.id', $users_ids);
            }

            if(!is_null($excludes_ids)) {
                $model = $model->whereNotIn('users.id', $excludes_ids);
            }

            $users = $model->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
                            ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                            ->whereIn('roles.name', $roles)
                            ->select('users.*')
                            ->get();

            if(count($users)) {
                foreach ($users as $key => $user) {
                    $message = str_replace('{user_name}', $user->first_name .' '.$user->last_name, $request->message);
                    $notif = [
                        'subject' => $request->subject,
                        'message' => [$message],
                    ];
                    $user->notify(new AppNotification($notif));
                }
            }

            $this->responder->set('message', 'Broadcast success');
            $this->responder->set('data', null);
            $this->responder->setStatus(200, 'Broadcast');
            return $this->responder->response();
        } catch (\Exception $e) {
            $this->responder->set('message', $e->getMessage());
            $this->responder->setStatus(500, 'Internal server error.');
            return $this->responder->response();
        }
    }

}
