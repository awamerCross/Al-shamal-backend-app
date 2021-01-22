<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\ISetting;
use App\Repositories\Interfaces\IUser;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    protected $settingRepo,$userRepo;

    public function __construct(ISetting $setting,IUser $user)
    {
        $this->settingRepo  = $setting;
        $this->userRepo     = $user;
    }


    /***************************  get all settings  **************************/
    public function index(){
        $data = $this->settingRepo->getAppInformation();
        return view('admin.settings.index',compact('data'));
    }


    /***************************  update settings  **************************/
    public function update(Request $request){
        $this->settingRepo->updateSetting($request->all());
        return back()->with('success','تم الحفظ');
    }


    /***************************  message all  **************************/
    public function messageAll(Request $request,$type){

        $this->userRepo->messageAll($request->all(),$type);
        return back()->with('success','تم الارسال');
    }

    /***************************  message one  **************************/
    public function messageOne(Request $request,$type){

        $this->userRepo->messageOne($request->all(),$type);
        return back()->with('success','تم الارسال');
    }

    /***************************  send email  **************************/
    public function sendEmail(Request $request){

        $this->settingRepo->sendEmail($request->all());
        return back()->with('success','تم الارسال');
    }
}
