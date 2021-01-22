<?php

namespace App\Repositories\Eloquent;

use App\Models\Rate;
use App\Traits\Responses;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Repositories\Interfaces\IRate;

class RateRepository extends AbstractModelRepository implements IRate
{

    use   Responses;


    public function __construct(Rate $model)
    {
        parent::__construct($model);
    }

    public function addUpdateRate($attributes=[] , $user_id)
    {
         return  DB::transaction(function ()   use ($attributes , $user_id) {
            $rate = $this->model->updateOrCreate(
                [
                    'user_id'   => $user_id ,
                    'rated_id'   => $attributes['rated_id'] ,
                ],[
                    'rate'         => $attributes['rate']
                ]) ;
            return $rate;
        });
    }
 }
