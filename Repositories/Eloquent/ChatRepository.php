<?php

namespace App\Repositories\Eloquent;

use Hash;
use App\Models\Chat;
use App\Traits\Responses;
use App\Traits\UploadTrait;
use Illuminate\Support\Facades\DB;
//use mysql_xdevapi\Collection;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Repositories\Interfaces\IChat;
use Collection;
use Auth;
class ChatRepository extends AbstractModelRepository implements IChat
{

    use   UploadTrait;
    use   Responses;


    public function __construct(Chat $model)
    {
        parent::__construct($model);
    }

    public function whereIn($array , $type = 'id')
    {
        return $this->model->with(['sender' , 'recevier'])->whereIn($type , $array)->orderBy('id', 'DESC')->get();
    }

    public function createMessage($attributes = [])
    {
        return  DB::transaction(function ()   use ($attributes) {
            $attributes['s_id']             = auth()->id();
            $attributes['room']             = $attributes['ad_id'];
            $attributes['type']             = 1;
            $user = $this->model->create($attributes);
            return $user;
        });
    }

    public function getUserMessages()
    {
        $msgs = [];
        $collection1 = collect($this->model->where('r_id' ,auth()->id())->select(['s_id as user','room'])->get());
        $collection2 = collect($this->model->Where('s_id' ,auth()->id())->select(['r_id as user' ,'room'])->get());
        $collection = $collection1->merge($collection2);
        $collection = array_unique($collection->toArray() ,SORT_REGULAR );
        foreach ($collection as $b) {
            $msgs[] = $this->model->where(function ($query) use ($b) {
                $query->where('ad_id', $b['room'])
                      ->where('s_id', auth()->id())
                      ->where('r_id', $b['user']);

            })->orWhere(function ($query) use ($b) {
                $query->where('ad_id', $b['room'])
                      ->where('r_id', auth()->id())
                      ->where('s_id', $b['user']);

            })->orderBy('id', 'DESC')
                ->first()->id;
        }
        return  $msgs;
    }

    public function getMessages($attributes = [])
    {
        $chats =  $this->model->with(['sender' , 'recevier'])->where(function ($query) use ($attributes) {
                    $query->where('ad_id', $attributes['ad_id'])
                        ->where('s_id', auth()->id())
                        ->where('r_id', $attributes['user_id']);

                })->orWhere(function ($query) use ($attributes) {
                    $query->where('ad_id', $attributes['ad_id'])
                        ->where('r_id', auth()->id())
                        ->where('s_id', $attributes['user_id']);

                })->orderBy('id', 'ASC')->get();

        $chats->map(function ($chat){
            $chat->seen = 1 ;
            $chat->save();
        });
        return $chats ;
    }


    public function countConversations()
    {
       return $this->model->where('r_id' ,auth()->id())->where('seen' ,0)->count();
    }

    public function deleteChat($attributes)
    {
        $chats =  $this->model->where(function ($query) use ($attributes) {
            $query->where('ad_id', $attributes['ad_id'])
                ->where('s_id', auth()->id())
                ->where('r_id', $attributes['user_id']);

        })->orWhere(function ($query) use ($attributes) {
            $query->where('ad_id', $attributes['ad_id'])
                ->where('r_id', auth()->id())
                ->where('s_id', $attributes['user_id']);


        })->delete() ;
        return back()->with('danger' , __('site.ChatDeleted'));
    }
 }
