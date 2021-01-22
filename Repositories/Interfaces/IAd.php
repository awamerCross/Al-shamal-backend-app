<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

interface IAd extends IModelRepository
{
    public function acceptedAds();
    public function waitAcceptedAds();
    public function storeAd($attributes=[]);
    public function store($attributes = []);
    public function addAd($attributes=[],$user_id);
    public function add($attributes = []);
    public function update($attributes = [],$ad); public function acceptUnAccept($Ad);
    public function filterAds($attributes = [] , $page = 0);
    public function lastSeenAds($ids);
    public function similerAds($ad_id);
    public function deleteImage($id);
   
}
