<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\IRate;
use App\Http\Requests\Site\RateRequest;


class RateController extends Controller
{
    protected $rateRepo;

    public function __construct(IRate $rateRepo)
    {
        $this->rateRepo = $rateRepo;
    }

    public function rate(RateRequest $request)
    {
        $this->rateRepo->addUpdateRate($request->validated() , auth()->id());
        return response()->json();
    }
}
