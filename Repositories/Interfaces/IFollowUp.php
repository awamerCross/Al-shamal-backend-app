<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

interface IFollowUp extends IModelRepository
{
    public function followOrUnFollow($attributes = []);
    public function followers($id);
    public function update($attributes = [],$user);
}
