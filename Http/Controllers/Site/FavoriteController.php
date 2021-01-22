<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\IFavorite;

class FavoriteController extends Controller
{
    protected $FavRepo;

    public function __construct(IFavorite $FavRepo)
    {
        $this->FavRepo                  = $FavRepo;
    }

    public function favUnFavAd(Request $request)
    {
        $status = $this->FavRepo->favUnFav(auth()->id() , $request->ad_id);
        $msg    = $status == 1 ? __('apis.fav') : __('apis.unFav') ;
       return response()->json(['msg' => $msg ,'status' => $status]);
    }
}
