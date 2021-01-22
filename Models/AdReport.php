<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdReport extends Model
{
    protected $fillable = ['ad_id','reason_id','user_id'];

    public function ad()
    {
        return $this->belongsTo('App\Models\Ad', 'ad_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
    public function reason()
    {
        return $this->belongsTo('App\Models\AdReportReason', 'reason_id', 'id');
    }


}
