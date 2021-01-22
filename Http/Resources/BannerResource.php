<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BannerResource extends JsonResource
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
            'id'                => (int)       $this->id,
            'title'             => (string)    $this->title,
            'icon'              => (string)    url('public/storage/images/sliders/'.$this->icon),
        ];
    }
}
