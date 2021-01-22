<?php

namespace App\Repositories\Eloquent;

use App\Models\PhotoAd;
use App\Traits\Responses;
use App\Traits\UploadTrait;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Repositories\Interfaces\IPhotoAd;

class PhotoAdRepository extends AbstractModelRepository implements IPhotoAd
{

    use   UploadTrait;
    use   Responses;


    public function __construct(PhotoAd $model)
    {
        parent::__construct($model);
    }

    public function acceptedAds()
    {
        return $this->model->with('user')->where('accepted', 1)->latest()->get();
    }
    public function unAcceptedAds()
    {
        return $this->model->with('user')->where('accepted', 0)->latest()->get();
    }
    public function acceptUnAccept($photoAd)
    {
        $photoAd->accepted = $photoAd->accepted == 1 ? 0 : 1 ;
        $photoAd->save();
        return $photoAd;
    }
 }
