<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LastSeen extends Model
{
    protected $fillable = ['user_id','ad_id'];
    
}
