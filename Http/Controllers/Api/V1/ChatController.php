<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\Responses;
use App\Http\Resources\BannerResource;
use App\Repositories\Interfaces\IChat;
use App\Repositories\Interfaces\IUser;
use App\Http\Requests\Api\SendMessageRequest;
use App\Http\Requests\Api\InboxRequest;
use App\Notifications\Api\NewMessageNotification ;
use App\Jobs\NewMessage;
use App\Http\Resources\ChatResource;

class ChatController extends Controller
{
    use Responses;
    private $Repo;
    private $UserRepo;
    public function __construct(IChat $Repo , IUser $UserRepo)
    {
        $this->Repo       = $Repo;
        $this->UserRepo  = $UserRepo;
    }

    public function sendMessage(SendMessageRequest $request)
    {
        $receiver = $this->UserRepo->find($request->r_id);
        $message =  $this->Repo->createMessage($request->validated());

        if ($receiver->is_notify == 1)
        {
            $data = [
                'sender'        => auth()->id(),
                'title_ar'      => 'رسالة جديدة',
                'title_en'      => 'New Message',
                'message_ar'    => 'لديك رساله جديده من ' .auth()->user()->name,
                'message_en'    => 'New Message From ' .auth()->user()->name,
                'data'          => [
                    'type'       => 1 ,
                    'user_id'    => auth()->id(),
                    'name'       => auth()->user()->name,
                    'avatar'     => asset('public/storage/images/users/'. auth()->user()->avatar),
                    'message_id' => $message->id,
                    'ad_id'      => $request->ad_id ,
                    'message'    => $message->message ,
//                    'date'       => date('A g:i ', strtotime($message->created_at)) ,
                    'date'       => $message->created_at->diffForHumans() ,
                    'count'      => $receiver->countChat() ,
                ],
            ];
            dispatch(new NewMessage($receiver, $data));
        }
        $this->sendResponse(new ChatResource($message) , __('apis.messageSended'));
    }

    public function conversations()
    {
        $this->sendResponse(ChatResource::collection($this->Repo->whereIn($this->Repo->getUserMessages())));
    }

    public function inbox(InboxRequest $request)
    {
        $this->sendResponse(ChatResource::collection( $this->Repo->getMessages($request->validated())));
    }

    public function countConversations()
    {
        $this->sendResponse($this->Repo->countConversations());
    }

}
