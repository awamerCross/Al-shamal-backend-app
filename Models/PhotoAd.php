<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\UploadTrait;


class PhotoAd extends Model
{
    use UploadTrait;

    protected $fillable = ['image','url','user_id','accepted']; 

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
    public function setImageAttribute($value)
    {
        if ($value != null)
        {
            $this->attributes['image'] = $this->uploadAllTyps($value, 'photoProducts');
        }
    }


    //  public function getImageAttribute($value)
    // {
    //     return url('public/storage/images/photoads/'.$value);
    // }
}
