<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\Responses;

use App\Http\Resources\BannerResource;
use App\Repositories\Interfaces\IBanner;

class BannerController extends Controller
{
    use     Responses;

    private $Repo;

    public function __construct(IBanner $Repo)
    {
        $this->Repo  = $Repo;
    }

    public function banners()
    {
        $categories  =  BannerResource::collection($this->Repo->get());
        $this->sendResponse($categories);
    }

}
