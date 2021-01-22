<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\IChat;
use App\Repositories\Interfaces\IUser;
use App\Http\Requests\Site\SendMessageRequest;
use App\Jobs\NewMessage;

class ChatController extends Controller
{
    protected $Repo;
    protected $UserRepo;

    public function __construct(IChat $Repo ,IUser $UserRepo )
    {
        $this->Repo     = $Repo;
        $this->UserRepo = $UserRepo;
    }

    public function sendMessage(SendMessageRequest $request)
    {
        $receiver = $this->UserRepo->find($request->r_id);
        $message  =  $this->Repo->createMessage($request->all());

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
                    'message_id' => $message->id,
                    'ad_id'      => $request->ad_id ,
                    'message'    => $message->message ,
                    'date'       => $message->created_at->diffForHumans() ,
//                    'date'       => date('A g:i ', strtotime($message->created_at)) ,
                    'date'       => $message->created_at->diffForHumans() ,
                    'count'      => $receiver->countChat()  ,
                ],
            ];
            dispatch(new NewMessage($receiver, $data));
        }
        if ($request->js){
            $message2 = view('site.chat.message' ,compact('message'))->render();
            return response()->json(['msg' => $message2 , 'message' => $message]);
        }else{
            return redirect('chat/'.$message->id);
        }
    }

    public function chat($id = null)
    {
        $chats = $this->Repo->whereIn($this->Repo->getUserMessages()) ;
        $chats = $chats->map(function ($chat){
            return [
                        'avatar' => auth()->id() != $chat->s_id ? $chat->sender->avatar : $chat->recevier->avatar,
                        'sender' => auth()->id() != $chat->s_id ? $chat->s_id : $chat->r_id,
                        'name'   => auth()->id() != $chat->s_id ? $chat->sender->name : $chat->recevier->name,
                        'date'   => date('m/d/Y', strtotime($chat->created_at)),
                        'ad_id'  => $chat->ad_id,
                        'id'     => $chat->id,
                        'message'=> $chat->message,
                   ];
        });
        return view('site.chat.index',compact('chats' ,'id'));
    }

    public function loadChat(Request $request)
    {
        $chat     = $this->Repo->find($request->id) ;
        $ad_id    = $chat->ad_id ;
        $messages = $this->Repo->getMessages(['user_id' => $chat->s_id == auth()->id() ? $chat->r_id : $chat->s_id ,'ad_id' => $chat->ad_id]);
        $user     = $this->UserRepo->find($chat->s_id == auth()->id() ? $chat->r_id : $chat->s_id);
        $inbox    = view('site.chat.chat_content',compact('messages' ,'user' ,'ad_id'))->render();
        return response()->json(['inbox' => $inbox]);
    }

    public function deletedChat($ad_id , $user_id)
    {
       $this->Repo->deleteChat(['user_id' => $user_id ,'ad_id' => $ad_id]);
        return back();

    }

}
