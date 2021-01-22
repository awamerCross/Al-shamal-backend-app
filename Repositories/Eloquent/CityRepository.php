<?php

namespace App\Repositories\Eloquent;

use App\Models\City;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Repositories\Interfaces\ICity;

class CityRepository extends AbstractModelRepository implements ICity
{
    public function __construct(City $model)
    {
        parent::__construct($model);
    }
    public function citiesByCountry($id)
    {
        return $this->model->with('country')->where('country_id',$id)->latest()->get();
    }
 }
