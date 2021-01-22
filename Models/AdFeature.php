<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdFeature extends Model
{
    protected $fillable = ['ad_id','feature_id','value'];

     public function feature()
     {
         return $this->belongsTo('App\Models\Feature', 'feature_id', 'id');
     }
}
