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

class ChatsResourcesController extends ApiResourcesController
{
    // TODO: This contacts chat only for DEN case
    public function getContacts(Request $request) {
        try {
            $this->checkPermissions('getContacts', 'read');
        } catch (\Exception $e) {
            $this->responder->set('message', 'You do not have authorization.');
            $this->responder->setStatus(401, 'Unauthorized');
            return $this->responder->response();
        }

        try {
            $user = auth()->user();
            $contacts = [];
            if($user->hasRole('agent')) {
                $contacts = User::where('referral_id', $user->den_id)
                                ->orWhere('den_id', $user->referral_id) //? NOTE: should contact list show their referrer
                                ->get();
            }

            if($user->hasRole('student')) {
                $contacts = User::where('den_id', $user->referral_id)
                                ->get();
            }

            $this->responder->set('message', 'Data retrieved');
            $this->responder->set('data', $contacts);
            return $this->responder->response();
        } catch(\Exception $e) {
            $this->responder->set('message', $e->getMessage());
            $this->responder->setStatus(500, 'Internal server error.');
            return $this->responder->response();
        }
    }

    public function getChatsHistory(Request $request, Chats $chats){
        try {
            $this->checkPermissions('getChatsHistory', 'read');
        } catch (\Exception $e) {
            $this->responder->set('message', 'You do not have authorization.');
            $this->responder->setStatus(401, 'Unauthorized');
            return $this->responder->response();
        }

        try {
            $history = $chats->userChatsHistory(auth()->id());

            $this->responder->set('message', 'Data retrieved');
            $this->responder->set('data', $history);
            return $this->responder->response();
        } catch(\Exception $e) {
            $this->responder->set('message', $e->getMessage());
            $this->responder->setStatus(500, 'Internal server error.');
            return $this->responder->response();
        }
    }

    // NOTE: compose new message/chat
    public function createSession(Request $request, ChatSessions $chatSessions, ChatSessionUsers $chatSessionUsers){
        try {
            $this->checkPermissions('createSession', 'read');
        } catch (\Exception $e) {
            $this->responder->set('message', 'You do not have authorization.');
            $this->responder->setStatus(401, 'Unauthorized');
            return $this->responder->response();
        }

        try {

            $validator = Validator::make($request->all(), [
                'type' => [
                    'required',
                    'string',
                    Rule::in(['private', 'group', 'channel']),
                ],
                'participant' => [
                    Rule::requiredIf(function () use ($request) {
                        return $request->get('type') == 'private';
                    }),
                    'integer',
                ],
                'participants' => [
                    Rule::requiredIf(function () use ($request) {
                        return $request->get('type') == 'group';
                    }),
                    'array',
                ],
                'message' => [
                    Rule::requiredIf(function () use ($request) {
                        return $request->get('type') == 'private';
                    }),
                    'string'
                ],
                'subject' => [
                    Rule::requiredIf(function () use ($request) {
                        return $request->get('type') == 'group';
                    }),
                    'string'
                ],
                'description' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                $this->responder->set('errors', $validator->errors());
                $this->responder->set('message', $validator->errors()->first());
                $this->responder->setStatus(400, 'Bad Request.');
                return $this->responder->response();
            }

            $participants = [auth()->id(), $request->get('participant')];
            $sessionsExist = $chatSessionUsers->checkUsersSessionExist($participants);
            // Create new sessions for these users
            if(!$sessionsExist) {
                $chatSessions = ChatSessions::create([
                    'type' => $request->get('type'),
                ]);

                // FIXME: fix issue uuid below
                $users = [
                    [
                        'id' => Uuid::uuid4()->toString(),
                        'session_id' => $chatSessions->id,
                        'user_id' => auth()->id()
                    ],
                    [
                        'id' => Uuid::uuid4()->toString(),
                        'session_id' => $chatSessions->id,
                        'user_id' => $request->get('participant')
                    ]
                ];
                // TODO: find a way how to create session users without set id and session_id like above
                $chatSessions->users()->insert($users);
            }

            $session_id = $chatSessionUsers->usersSession($participants)->session_id;
            $chatSessions = ChatSessions::find($session_id);
            $message = $chatSessions->messages()->create([
                'content' => $request->get('message'),
                'type' => 'text'
            ]);

            $chat = $message->createChat($session_id);

            $this->responder->set('message', 'Message composed');
            $this->responder->set('data', $chat);
            return $this->responder->response();
        } catch(\Exception $e) {
            $this->responder->set('message', $e->getMessage());
            $this->responder->setStatus(500, 'Internal server error.');
            return $this->responder->response();
        }
    }

    public function getMessagesBySession(Request $request, Chats $chats, $id){
        try {
            $this->checkPermissions('getMessagesBySession', 'read');
        } catch (\Exception $e) {
            $this->responder->set('message', 'You do not have authorization.');
            $this->responder->setStatus(401, 'Unauthorized');
            return $this->responder->response();
        }

        try {

            $history = $chats->userChatsHistoryBySession(auth()->id(), $id);

            $this->responder->set('message', 'Data retrieved');
            $this->responder->set('data', $history);
            return $this->responder->response();
        } catch(\Exception $e) {
            $this->responder->set('message', $e->getMessage());
            $this->responder->setStatus(500, 'Internal server error.');
            return $this->responder->response();
        }
    }

    public function createMessageBySession(Request $request, $id){
        try {
            $this->checkPermissions('createMessageBySession', 'read');
        } catch (\Exception $e) {
            $this->responder->set('message', 'You do not have authorization.');
            $this->responder->setStatus(401, 'Unauthorized');
            return $this->responder->response();
        }

        try {

            $validator = Validator::make($request->all(), [
                'message' => [
                    'required',
                    'string'
                ]
            ]);

            if ($validator->fails()) {
                $this->responder->set('errors', $validator->errors());
                $this->responder->set('message', $validator->errors()->first());
                $this->responder->setStatus(400, 'Bad Request.');
                return $this->responder->response();
            }

            $chatSessions = ChatSessions::find($id);
            $message = $chatSessions->messages()->create([
                'content' => $request->get('message'),
                'type' => 'text'
            ]);

            $chat = $message->createChat($id);

            $this->responder->set('message', 'Data retrieved');
            $this->responder->set('data', $chat);
            return $this->responder->response();
        } catch(\Exception $e) {
            $this->responder->set('message', $e->getMessage());
            $this->responder->setStatus(500, 'Internal server error.');
            return $this->responder->response();
        }
    }

    public function markChatsAsRead(Request $request, Chats $chats, $session_id, $id){
        try {
            $this->checkPermissions('markChatsAsRead', 'read');
        } catch (\Exception $e) {
            $this->responder->set('message', 'You do not have authorization.');
            $this->responder->setStatus(401, 'Unauthorized');
            return $this->responder->response();
        }

        try {

            $chat = $chats->find($id);
            $chat->read_at = now();
            $chat->save();

            $this->responder->set('message', 'Chat marked as read');
            $this->responder->set('data', $chat);
            return $this->responder->response();
        } catch(\Exception $e) {
            $this->responder->set('message', $e->getMessage());
            $this->responder->setStatus(500, 'Internal server error.');
            return $this->responder->response();
        }
    }

    public function markChatsAsUnread(Request $request, Chats $chats, $session_id, $id){
        try {
            $this->checkPermissions('markChatsAsUnread', 'read');
        } catch (\Exception $e) {
            $this->responder->set('message', 'You do not have authorization.');
            $this->responder->setStatus(401, 'Unauthorized');
            return $this->responder->response();
        }

        try {

            $chat = $chats->find($id);
            $chat->read_at = null;
            $chat->save();

            $this->responder->set('message', 'Chat marked as unread');
            $this->responder->set('data', $chat);
            return $this->responder->response();
        } catch(\Exception $e) {
            $this->responder->set('message', $e->getMessage());
            $this->responder->setStatus(500, 'Internal server error.');
            return $this->responder->response();
        }
    }

    public function clearChats(Request $request, $id){
        try {
            $this->checkPermissions('clearChats', 'read');
        } catch (\Exception $e) {
            $this->responder->set('message', 'You do not have authorization.');
            $this->responder->setStatus(401, 'Unauthorized');
            return $this->responder->response();
        }

        try {

            // $this->model
            //     ->where('notifiable_id', $request->user()->id)
            //     ->where('read_at', null)
            //     ->update(['read_at' => now()]);

            $this->responder->set('message', 'Data retrieved');
            $this->responder->set('data', null);
            return $this->responder->response();
        } catch(\Exception $e) {
            $this->responder->set('message', $e->getMessage());
            $this->responder->setStatus(500, 'Internal server error.');
            return $this->responder->response();
        }
    }

    public function blockUser(Request $request, $id){
        try {
            $this->checkPermissions('blockUser', 'read');
        } catch (\Exception $e) {
            $this->responder->set('message', 'You do not have authorization.');
            $this->responder->setStatus(401, 'Unauthorized');
            return $this->responder->response();
        }

        try {

            // $this->model
            //     ->where('notifiable_id', $request->user()->id)
            //     ->where('read_at', null)
            //     ->update(['read_at' => now()]);

            $this->responder->set('message', 'Data retrieved');
            $this->responder->set('data', null);
            return $this->responder->response();
        } catch(\Exception $e) {
            $this->responder->set('message', $e->getMessage());
            $this->responder->setStatus(500, 'Internal server error.');
            return $this->responder->response();
        }
    }

    public function unblockUser(Request $request, $id){
        try {
            $this->checkPermissions('unblockUser', 'read');
        } catch (\Exception $e) {
            $this->responder->set('message', 'You do not have authorization.');
            $this->responder->setStatus(401, 'Unauthorized');
            return $this->responder->response();
        }

        try {

            // $this->model
            //     ->where('notifiable_id', $request->user()->id)
            //     ->where('read_at', null)
            //     ->update(['read_at' => now()]);

            $this->responder->set('message', 'Data retrieved');
            $this->responder->set('data', null);
            return $this->responder->response();
        } catch(\Exception $e) {
            $this->responder->set('message', $e->getMessage());
            $this->responder->setStatus(500, 'Internal server error.');
            return $this->responder->response();
        }
    }

}
