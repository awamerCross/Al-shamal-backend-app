<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'parent_id'         => (int)       $this->parent_id,
            'name'              => (string)    $this->name,
            'icon'              => (string)    url('public/storage/images/categories/'.$this->icon),
            'has_subs'          => $this->childes->count() > 0 ? 1 : 0 ,
            'features'          => $this->features->count() > 0 ? $this->features->map(function ($feature){
                return [
                    'id'     =>  $feature->id ,
                    'name'   =>  $feature->name ,
                ];
            }) : [],
        ];
    }
}
