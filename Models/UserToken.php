<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserToken extends Model
{
    protected $guarded   = ['id'];
    protected $fillable = [ 'device_id', 'device_type', 'user_id' ];

    public function user()
    {
        return $this -> belongsTo( User::class, 'user_id' );
    }
}



