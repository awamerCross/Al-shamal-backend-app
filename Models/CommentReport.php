<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommentReport extends Model
{
    protected $fillable = ['comment_id','reason_id','user_id'];

    public function comment()
    {
        return $this->belongsTo('App\Models\AdComment', 'comment_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
    public function reason()
    {
        return $this->belongsTo('App\Models\CommentReportReason', 'reason_id', 'id');
    }
}
