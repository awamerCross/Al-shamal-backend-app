<?php

namespace App\Repositories\Eloquent;

use App\Models\LastSeen;
use App\Traits\Responses;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Repositories\Interfaces\ILastSeen;

class LastSeenRepository extends AbstractModelRepository implements ILastSeen
{

    use   Responses;


    public function __construct(LastSeen $model)
    {
        parent::__construct($model);
    }

    public function lastseen($user_id)
    {
        return $this->model->where('user_id' , $user_id)->pluck('ad_id')->toArray();
    }

    public function plusLastSeen($attributes=[])
    {
        $ad = $this->model->where(['user_id' => $attributes['user_id'] ,'ad_id' => $attributes['ad_id']])->orderBy('id' ,'DESC')->get() ;
        if ($ad->count() == 0)
        {
            $count = $this->model->where('user_id' , $attributes['user_id'])->orderBy('id' ,'DESC')->get() ;
            if($count->count() >= 15 ){
                $count->first()->delete() ;
            }
            $this->model->create([
               'ad_id'     => $attributes['ad_id'] ,
               'user_id'   => $attributes['user_id'] ,
            ]);
        }
        return ;
    }

    
 }
