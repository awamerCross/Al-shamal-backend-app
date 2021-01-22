<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\IFollowUp;

class FollowUpController extends Controller
{
    protected $followRepo;

    public function __construct(IFollowUp $followRepo)
    {
        $this->followRepo = $followRepo;
    }

    public function follow(Request $request)
    {
       $return = $this->followRepo->followOrUnFollow(['follower_id' => auth()->id() , 'followed_id'  => $request->user_id]);
       $html = $return == 0 ? __('site.follow') : __('site.un_follow') ;
       return response()->json(['status' => $return , 'html' => $html]);
    }

}
