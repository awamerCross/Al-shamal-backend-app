<?php

namespace App\Models;

use App\Traits\UploadTrait;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    use UploadTrait ;
    protected $fillable = ['image','user_id','ad_id','bank_id','account_name','account_number','ammount','bank_name'];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function ad()
    {
        return $this->belongsTo('App\Models\Ad', 'ad_id', 'id');
    }

    public function bank()
    {
        return $this->belongsTo('App\Models\Bank', 'bank_id', 'id');
    }

     public function setImageAttribute($value)
    {
        $this->attributes['image'] = $this->uploadAllTyps($value, 'transfers');
    }

    // public function getImageAttribute($value)
    // {
    //     return url('public/storage/images/transfers/'.$value);
    // }
}
