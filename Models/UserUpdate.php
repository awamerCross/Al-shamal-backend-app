<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserUpdate extends Model
{
    protected $fillable = ['type','password','phone','code','newPhoneCode','user_id','email'];
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
}
