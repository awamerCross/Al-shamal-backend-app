<?php

namespace App\Http\Resources\Api;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use JWTAuth;
class UserResource extends JsonResource
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
            'id'                               => (int)     $this->id,
            'name'                             => (string)  $this->name,
            'email'                            => (string)  $this->email,
            'phone'                            => (string)  $this->phone,
            'key'                              => (double)  $this->key,
            'user_type'                        => (int)     $this->user_type,
            'avatar'                           => (string)  url('public/storage/images/users/'.$this->avatar),
            'block'                            => (boolean) $this->block,
            'active'                           => (boolean) $this->active,
            'lang'                             => (string)  $this->lang,
            'country'                          => (string)  $this->country->name,
            'country_id'                       => (double)  $this->country_id,
            'city'                             => (string)  $this->city->name,
            'city_id'                          => (double)  $this->city_id,
            'token'                            => (string)  $this->token,
            'rate'                             =>  $this->rate() ,
            'rateCount'                        =>  $this->rates->count() ,
            'is_notify'                        =>  $this->is_notify  == 1 ? true : false,
            'device_id'                        =>  $this->device_id,
        ];
    }
}
