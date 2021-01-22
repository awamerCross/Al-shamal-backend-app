<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationsResource extends JsonResource
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
            'id'                   => $this->id,
            'notification'         => $this->id ,
            'message'              => $this->data['message_'.lang()],
            'ad_id'                => isset($this->data['data']['ad_id']) ? $this->data['data']['ad_id'] : null,
            'comment_id'           => isset($this->data['data']['comment_id']) ? $this->data['data']['comment_id'] : null,
            'type'                 => $this->data['data']['type'],
            'date'                 => $this->created_at->diffForHumans(),
        ];
    }
}
