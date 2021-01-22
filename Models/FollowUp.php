<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FollowUp extends Model
{
      protected $fillable = ['followed_id','follower_id'];
    
}
