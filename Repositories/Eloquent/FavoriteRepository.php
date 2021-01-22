<?php

namespace App\Repositories\Eloquent;

use App\Models\Favorite;
use App\Traits\Responses;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Repositories\Interfaces\IFavorite;

class FavoriteRepository extends AbstractModelRepository implements IFavorite
{

    use   Responses;


    public function __construct(Favorite $model)
    {
        parent::__construct($model);
    }

    public function favoriets($user_id)
    {
        return $this->model->where('user_id' , $user_id)->pluck('ad_id')->toArray();
    }

    public function favUnFav($user_id , $ad_id)
    {
        $row = $this->model->where(['user_id' => $user_id , 'ad_id' => $ad_id])->first();
        if ($row) {
            $row->delete() ;
            return  0 ;
        }else{
            $this->model->create([
                'user_id' => $user_id , 
                'ad_id'   => $ad_id
            ]);
            return 1 ; 
        }
    }
 }
