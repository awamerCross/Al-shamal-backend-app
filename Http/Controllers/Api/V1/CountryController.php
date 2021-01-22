<?php

namespace App\Http\Controllers\Api\V1;

use App\Traits\Responses;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CountryResource;
use App\Repositories\Interfaces\ICountry;

class CountryController extends Controller
{
    use     Responses;

    private $Repo;

    public function __construct(ICountry $Repo)
    {
        $this->Repo  = $Repo;
    }

    public function countries(){
        $cities =  CountryResource::collection($this->Repo->get());
        $this->sendResponse($cities);
    }
}
