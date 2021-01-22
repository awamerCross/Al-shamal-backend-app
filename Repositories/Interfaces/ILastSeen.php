<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

interface ILastSeen extends IModelRepository
{
    public function lastseen($user_id);
    public function plusLastSeen($attributes=[]);
}
