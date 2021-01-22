<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $fillable = ['device_id','ad_id','user_id'];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function ad()
    {
        return $this->belongsTo('App\Models\Ad', 'ad_id', 'id');
    }
}
