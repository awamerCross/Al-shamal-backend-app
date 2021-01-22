<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
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
            'id'        => $this->id ,
            'comment'   => $this->comment ,
            'user_id'   => $this->user_id ,
            'user_name' => $this->user->name ,
            'date'      => $this->created_at->diffForHumans(),
            'avatar'    => url('public/storage/images/users/'.$this->user->avatar) ,
        ];
    }
}
