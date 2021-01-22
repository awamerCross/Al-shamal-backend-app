<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

interface IFavorite extends IModelRepository
{
    public function favoriets($user_id);
    public function favUnFav($user_id , $ad_id);
}
