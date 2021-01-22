<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use http\Env\Response;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\IPhotoAd;
use App\Http\Requests\Site\adPhotoAdReqest;
use App\Http\Requests\Site\UpdatePhotoAdReqest;


class PhotoAdController extends Controller
{
    protected $photoAdRepo;

    public function __construct(IPhotoAd $photoAdRepo)
    {
        $this->photoAdRepo     = $photoAdRepo;
    }

    public function deletePhotoAd(Request $request)
    {
        $this->photoAdRepo->softDelete($this->photoAdRepo->findOrFail($request->ad_id));
        return response()->json(['msg' => __('site.deleted')]);
    }

    public function photoAds()
    {
        $ads = $this->photoAdRepo->acceptedAds();
        return view('site.photoAd.photo_ads',compact('ads'));
    }
    public function photoAdPage($id = null)
    {
        $ad = $this->photoAdRepo->find($id);
        return view('site.photoAd.add_form' ,compact('ad'));
    }

    public function adPhotoAd(adPhotoAdReqest $request)
    {
        $this->photoAdRepo->store($request->validated()+(['user_id' =>auth()->id()]));
        return Response()->json(['msg' => __('apis.added')]);
    }

    public function UpdatephotoAd(UpdatePhotoAdReqest $request ,$id)
    {
        $ad = $this->photoAdRepo->find($id);
        $this->photoAdRepo->update($request->validated() , $ad);
        return Response()->json(['msg' => __('apis.updated')]);
    }

}
