<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\IUser;
use App\Repositories\Interfaces\ICountry;
use App\Repositories\Interfaces\ICity;
use App\Http\Requests\Site\UpdateProfileRequest;
use App\Http\Requests\Site\UpdatePasswordRequest;
use App\Http\Requests\Site\UpdatePhoneRequest;
use App\Http\Requests\Site\updatePhoneCodeRequest;
use App\Http\Requests\Site\UpdateEmailRequest;

class UserController extends Controller
{
    protected $cityRepo;
    protected $userRepo;
    protected $countryRepo;

    public function __construct(IUser $userRepo ,ICountry $countryRepo,ICity $cityRepo)
    {
        $this->userRepo             = $userRepo;
        $this->countryRepo          = $countryRepo;
        $this->cityRepo             = $cityRepo;
    }

    public function providerInfo($id)
    {
       $user = $this->userRepo->find($id);
       return view('site.user.provider_info',compact('user'));
    }

    public function favorite()
    {
       $ads = auth()->user()->faveorites2;
       return view('site.pages.favorites',compact('ads'));
    }

    public function notification()
    {
        auth()->user()->unreadNotifications->markAsRead();
        $notifications = auth()->user()->notifications;
       return view('site.pages.notifications',compact('notifications'));
    }

    public function deleteNotifications(Request $request)
    {
        auth()->user()->notifications()->where('id', $request->id)->first()->delete();
       return response()->json(['msg' => __('site.notify_deleted')]);
    }

    public function deleteAllNotifications()
    {
        auth()->user()->notifications()->delete();
        return response()->json(['msg' => __('site.notifys_deleted')]);
    }

    public function profilePage()
    {
        $user = auth()->user();
        $favorite  = auth()->user()->faveorites2 ;
        $countries = $this->countryRepo->get() ;
        $cities = $this->cityRepo->get() ;
        return view('site.user.profile',compact('user','favorite' ,'countries','cities'));
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $this->userRepo->update($request->validated(),auth()->user());
        return response()->json(['val' => __('apis.updated')]);
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $this->userRepo->editPassword(['old_password' => $request->old_password ,'current_password' => $request->password]);
        return response()->json(['val' => __('apis.updated')]);
    }
    public function updatePhone(UpdatePhoneRequest $request)
    {
        $this->userRepo->updatePhoneRequest($request->validated());
        return response()->json(['val' => __('apis.send_activated') , 'status' => 0]);
    }
    public function updatePhoneCode(updatePhoneCodeRequest $request)
    {
        $this->userRepo->updatePhone($request->validated());
        return response()->json(['msg' => __('apis.phone_changed')]);
    }

    public function updateEmail(UpdateEmailRequest $request)
    {
        $this->userRepo->updateEmailRequest($request->validated());
        return response()->json(['val' => __('apis.send_activated') , 'status' => 1]);
    }
    public function updateEmailCode(updatePhoneCodeRequest $request)
    {
        $this->userRepo->updateEmail($request->validated());
        return response()->json(['msg' => __('apis.email_changed')]);
    }

    /*********************** sendAccountNumber ***************************/
    public function sendAccountNumber($accountNumber)
    {
        $this->userRepo->sendAccountNumber($accountNumber);
        return back()->with('success' ,__('site.number_send'));
    }
}
