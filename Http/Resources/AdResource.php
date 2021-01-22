<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
class AdResource extends JsonResource
{
    private $animation ;
    public function __construct($resource ,$animation)
    {
        // Ensure you call the parent constructor
        parent::__construct($resource);
        $this->resource = $resource;

        $this->animation = $animation ;
    }
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
            'title'             => $this->title,
            'description'       => $this->description,
            'icon'              => $this->images->count() > 0 ?  url('public/storage/resize/images/products/' . $this->image()) : url('public/storage/resize/images/products/default.png'),
            'country'           => ($this->country->name),
            'city'              => ($this->city->name),
            'category'          => ($this->category->name),
            'date'              => $this->created_at->diffForHumans(),
            'price'             => $this->price != null ? $this->price : __('site.no_price'),
            'user_name'         => $this->user->name,
            'animation '        => 800 + ($this->animation * 300 ) ,
        ];

    }
}
