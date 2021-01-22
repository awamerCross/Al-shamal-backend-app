<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $fillable = ['image','s_id','ad_id','r_id','message','type','seen','room'];

    public function sender()
    {
        return $this->belongsTo('App\Models\User', 's_id', 'id');
    }

    public function recevier()
    {
        return $this->belongsTo('App\Models\User'  , 'r_id', 'id');
    }

    public function ad()
    {
        return $this->belongsTo('App\Models\Ad', 'ad_id', 'id');
    }

    public function getImageAttribute($value)
    {
        return url('public/storage/images/chats/'.$value);
    }
}
