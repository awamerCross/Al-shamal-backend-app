<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\ILastSeen;
use App\Repositories\Interfaces\IAd;

class LastSeenController extends Controller
{
    protected $lastSeenRepo;

    public function __construct(ILastSeen $lastSeenRepo ,IAd $adRepo)
    {
        $this->lastSeenRepo             = $lastSeenRepo;
        $this->adRepo                   = $adRepo;
    }

    public function lastSeen()
    {
        $ads_ids = $this->lastSeenRepo->lastSeen(auth()->id()) ;
        $ads     = $this->adRepo->whereIn($ads_ids) ;
        return view('site.pages.last_seen',compact('ads'));
    }

    public function terms()
    {
        return view('site.pages.terms');
    }
    public function help()
    {
        return view('site.pages.help');
    }
}
