<?php

namespace App\Http\Controllers\Api\V1;

use App\Traits\Responses;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CityResource;
use App\Repositories\Interfaces\ICity;
use App\Http\Requests\Api\citiesByCountryRequest;

class CityController extends Controller
{
    use     Responses;

    private $citiesRepo;

    public function __construct(ICity $citiesRepo)
    {
        $this->citiesRepo  = $citiesRepo;
    }

    public function cities(){
        $cities =  CityResource::collection($this->citiesRepo->get());
        $this->sendResponse($cities);
    }

    public function citiesByCountry(citiesByCountryRequest $request){
        $cities =  CityResource::collection($this->citiesRepo->citiesByCountry($request->country_id));
        $this->sendResponse($cities);
    }
}
