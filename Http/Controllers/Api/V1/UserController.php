<?php

namespace App\Http\Controllers\Api\V1;

use App\Traits\Responses;
use Illuminate\Http\Request;
use App\Http\Resources\AdResource;
use App\Http\Resources\PhotoAdResource;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\IRate;
use App\Repositories\Interfaces\IUser;
use App\Http\Resources\Api\UserResource;
use App\Http\Requests\Api\RateUserRequest;
use App\Http\Requests\Api\providerDataRequest;
use App\Http\Resources\NotificationsResource;

class UserController extends Controller
{
    use     Responses;

    private $Repo;
    private $rateRepo;

    public function __construct(IUser $Repo,IRate $rateRepo)
    {
        $this->Repo          =   $Repo;
        $this->rateRepo      =   $rateRepo;
    }


    public function providerData(providerDataRequest $request)
    {
        $user = $this->Repo->find($request->user_id) ; 
        $ads  = AdResource::collection($user->ads) ;  
        $photoAds  = PhotoAdResource::collection($user->photoAds) ;
        $user = new UserResource($user);
        $data = ['user' => $user , 'ads' => $ads ,'photoAds' => $photoAds];
        $this->sendResponse($data);
    }

    public function rateUser(RateUserRequest $request)
    {
        $this->rateRepo->addUpdateRate($request->validated() , auth()->id());
        $this->sendResponse('' ,__('apis.rated'));
    }

    public function userAds()
    {
        $ads       = AdResource::collection(auth()->user()->ads) ;
        $photoads  = PhotoAdResource::collection(auth()->user()->photoAds) ;
        $this->sendResponse(['ads' => $ads , 'photoAds' => $photoads]);
    }

    public function changeNotifyStatue()
    {
        $user = auth()->user() ; 
        $user->update(['is_notify' => $user->is_notify == 1 ? 0 : 1 ]);
        $msg = $user->is_notify ? __('apis.openNotify') : __('apis.closeNotify') ;
        $this->sendResponse(['status' => $user->is_notify] , $msg);
    }

    public function notifications()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return NotificationsResource::collection(auth()->user()->notifications) ;
    }

    public function countNotifications()
    {
        $this->sendResponse(['count' => auth()->user()->unreadNotifications->count()] , '');
    }

    public function deleteNotifications(Request $request)
    {
        auth()->user()->notifications()->where('id', $request->id)->first()->delete();
        $this->sendResponse( '', __('site.notify_deleted'));
    }

}
