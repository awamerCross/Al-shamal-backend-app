<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdComment extends Model
{
      protected $fillable = ['comment','user_id','ad_id','show_data'];


      public function ad()
      {
          return $this->belongsTo('App\Models\Ad', 'ad_id', 'id');
      }
      public function user()
      {
          return $this->belongsTo('App\Models\User', 'user_id', 'id');
      }
}
