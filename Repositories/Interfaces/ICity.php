<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

interface ICity extends IModelRepository
{
    public function citiesByCountry($id);
}
