<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

interface IPhotoAd extends IModelRepository
{
    public function acceptedAds();
    public function unAcceptedAds();
    public function acceptUnAccept($photoAd);
}
