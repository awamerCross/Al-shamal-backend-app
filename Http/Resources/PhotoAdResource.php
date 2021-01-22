<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PhotoAdResource extends JsonResource
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
            'id'                => $this->id,
            'icon'              => url('public/storage/images/photoProducts/' . $this->image),
            'user'              => $this->user->name,
            'user_id'           => $this->user_id,
            'url'               => $this->url,
        ];
    }
}
