<?php

namespace App\Http\Controllers\Api\V1;

use App\Traits\Responses;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PhotoAdResource;
use App\Repositories\Interfaces\IPhotoAd;
use App\Http\Requests\Api\addPhotoAdRequest;

class PhotoAdsController extends Controller
{
    use     Responses;

    private $Repo;

    public function __construct(IPhotoAd $Repo)
    {
        $this->Repo  = $Repo;
    }

    public function photoAds(Request $request)
    {
        $ads = PhotoAdResource::collection($this->Repo->acceptedAds());
        $this->sendResponse($ads);
    }

    public function addPhotoAd(addPhotoAdRequest $request)
    {
        $this->Repo->store($request->validated() + (['accepted' => 0 , 'user_id' =>auth()->id()]));
        $this->sendResponse('',__('apis.photoadadded'));
    }

}
