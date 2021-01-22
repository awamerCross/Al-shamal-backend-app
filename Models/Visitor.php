<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    protected $fillable = ['user_id' , 'city' , 'country' , 'area' , 'ip' , 'latitude'
        , 'longitude' , 'zipCode' , 'regionName' , 'regionCode' , 'countryCode'] ;

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
}
