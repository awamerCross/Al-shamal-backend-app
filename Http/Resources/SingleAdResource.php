<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SingleAdResource extends JsonResource
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
            'title'             => $this->title,
            'title_ar'          => $this->getTranslations()['title']['ar'],
            'title_en'          => $this->getTranslations()['title']['en'],
            'description'       => $this->description,
            'description_ar'    => $this->getTranslations()['description']['ar'],
            'description_en'    => $this->getTranslations()['description']['en'],
            'icon'              => url('public/storage/images/products/' . $this->icon),
            'country'           => ($this->country->name),
            'country_id'        => ($this->country_id),
            'city'              => ($this->city->name),
            'city_id'           => ($this->city_id),
            'category'          => ($this->category->name),
            'category_id'       => ($this->category->id),
            'category_features' => $this->category->features->count() > 0 ? $this->features->map(function ($feature){
                return [
                    'id'     =>  $feature->id ,
                    'name'   =>  $feature->name ,
                ];
            }) : [],
            'category_has_subs' => $this->category->childes->count() > 0 ? 1 : 0,
            'categories'        => $this->category->getAllParents()->map(function ($category){
                return [
                    'id'                => $category->id,
                    'parent_id'         => $category->parent_id,
                    'name'              => $category->name,
                    'icon'              => url('public/storage/images/categories/'.$category->icon),
                    'has_subs'          => $category->childes->count() > 0 ? 1 : 0 ,
                    'features'          => $category->features->count() > 0 ? $this->features->map(function ($feature){
                        return [
                            'id'     =>  $feature->id ,
                            'name'   =>  $feature->name ,
                        ];
                    }) : [],
                ] ;
            }),
            'date'              => $this->created_at->diffForHumans(),
            'latitude'          => $this->latitude,
            'longitude'         => $this->longitude,
            'price'             => $this->price,
            'chat'              => $this->is_chat,
            'is_phone'          => $this->is_phone,
            'phone'             => $this->phone,
            'isFav'             => $this-> isFav(auth()->id()) == 0 ? false : true,
            'is_chat'           => $this->is_chat == 0 ? false : true ,
            'is_phone'          => $this->is_phone == 0 ? false : true ,
            'is_refresh'        => $this->is_refresh == 0 ? false : true ,
            'address'           => $this->address,
            'urlAdv'            => url('/ad-detailes/'.$this->identity) ,
            'comments'          => $this-> comments->count() > 0 ? $this->comments->map(function ($comment){
                return [
                    'id'        => $comment->id ,
                    'comment'   => $comment->comment ,
                    'user_id'   => $comment->user_id ,
                    'user_name' => $comment->user->name ,
                    'date'      => $comment->created_at->diffForHumans(),
                    'avatar'    => url('public/storage/images/users/'.$comment->user->avatar) ,
                ];
            }) : [],
            'features'          => $this-> features2->count() > 0 ? $this->features2->map(function ($feature){
                return [
                    'id'        => $feature->id ,
                    'name'      => $feature->feature->name ,
                    'value'     => $feature->value ,
                ];
            }) : [],
            'images'             =>  $this-> images->count() > 0 ? $this->images->map(function ($image){
                return [
                    'id'     =>  $image->id ,
                    'url'    =>  url('public/storage/resizeMid/images/products/'.$image->image) ,
                ];
            }) : [],
            'user'                => [
                'id'        =>  $this->user_id      ,
                'name'      =>  $this->user->name   ,
                'avatar'    =>  url('public/images/users'.$this->user->avatar)  ,
                // 'phone'     =>  $this->user->phone ,
                'rate'      =>  $this->user->rate() ,
            ],
        ];
    }
}
