<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\UploadTrait;


class AdImage extends Model
{
    use UploadTrait;

    protected $fillable = ['ad_id','image'];

     public function ad()
     {
        return $this->belongsTo('App\Models\Ad', 'ad_id', 'id');
     }

    public function setImageAttribute($value)
    {
        $this->attributes['image'] = $this->uploadAllTyps($value, 'products' , 200 , 400);
    }
}
