<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

interface IRate extends IModelRepository
{
    public function addUpdateRate($attributes=[] , $user_id);
}
