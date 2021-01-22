<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\IAd;


class SearchController extends Controller
{
    protected $adRepo;

    public function __construct(IAd $adRepo)
    {
        $this->adRepo             = $adRepo;
    }

    public function search(Request $request)
    {
        $keyword = $request->keyword ;
        $ads = $this->adRepo->filterAds(['keyword' => $request->keyword]);
        return view('site.pages.search' ,compact('ads' ,'keyword'));
    }
}
