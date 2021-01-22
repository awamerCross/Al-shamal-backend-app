<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon ;
class ChatResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'sender'     => auth()->id() == $this->s_id ? 1 : 0 ,
            'room'       => $this->room,
            'ad_id'      => $this->ad_id,
            'message'    => $this->message,
            'seen'       => $this->seen,
            'date'       => $this->created_at->diffForHumans(),
            'other'      => [
                'id'     => auth()->id() == $this->s_id ? $this->recevier->id   : $this->sender->id   ,
                'name'   => auth()->id() == $this->s_id ? $this->recevier->name : $this->sender->name ,
                'avatar' => auth()->id() == $this->s_id ?  url('public/storage/images/users/' . $this->recevier->avatar) : url('public/storage/images/users/' . $this->sender->avatar) ,
            ],
        ];
    }
}
