<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\Site\LoginRequest;
use App\Http\Requests\Site\forgetPasswordRequest;
use App\Http\Requests\Site\forgetPasswordCodeRequest;
use App\Http\Requests\Site\RegisterRequest;
use App\Repositories\Interfaces\IUser;
use App\Repositories\Interfaces\ICountry;
use App\Repositories\Interfaces\ICity;

class AuthController extends Controller
{

    protected $userRepo;
    protected $CountryRepo;
    protected $CityRepo;

    public function __construct(IUser $userRepo,ICountry $CountryRepo ,ICity $CityRepo )
    {
        $this->userRepo                   = $userRepo;
        $this->CountryRepo                = $CountryRepo;
        $this->CityRepo                   = $CityRepo;
    }

    /***************** change lang  *****************/
    public function SetLanguage($lang)
    {
        if ( in_array( $lang, [ 'ar', 'en' ] ) ) {

            if ( session() -> has( 'lang' ) )
                session() -> forget( 'lang' );

            session() -> put( 'lang', $lang );

        } else {
            if ( session() -> has( 'lang' ) )
                session() -> forget( 'lang' );

            session() -> put( 'lang', 'ar' );
        }

//        dd(session( 'lang' ));
        return back();
    }

    /***************** show login form *****************/
    public function loginForm()
    {
        $countries = $this->CountryRepo->get() ;
        return view('site.auth.login',compact('countries'));
    }

    /**************** show login form *****************/
    public function login(LoginRequest $request)
    {
       $status =  $this->userRepo->signIn($request->validated());
       if ($status['status'] == 1 ){
           return response()->json(['status' => 1 , 'msg' => __('site.logined')]);
       }elseif ($status['status'] == 0){
           return response()->json(['status' => 0 , 'msg' => __('site.check_password')]);
       }elseif ($status['status'] == 2){
           return response()->json(['status' => 2 , 'url' =>  url('activate/'.$status['user_id']) , 'msg' => __('site.need_activate')]);
       }elseif ($status['status'] == 3){
           return response()->json(['status' => 3 , 'msg' => __('site.blocked')]);
       }
    }

    /***************** show register form *****************/
    public function registerForm()
    {
        $countries = $this->CountryRepo->get() ;
        $cities    = $this->CityRepo->get() ;
        return view('site.auth.register',compact('countries','cities'));
    }
    /***************** show register *****************/
    public function register(RegisterRequest $request)
    {
        $user   = $this->userRepo->signUp($request->validated());
        return response()->json(['url' => url('activate/'.$user->id) , 'msg' => __('site.registerd')]);
    }
    /***************** activate user *****************/
    public function activate($id)
    {
        $user = $this->userRepo->find($id);
        $now         =  \Carbon\Carbon::now() ;
        $code_expire =  new  \Carbon\Carbon($user->code_expire) ;
        if($now >= $code_expire){
            $expire = 'expired' ;
        }else{
            $expire = $code_expire->diffInSeconds($now);
        }
        return view('site.auth.activate',compact('id' ,'expire'));
    }
    /***************** activate User *****************/
    public function activateUser(Request $request)
    {
        $user   = $this->userRepo->find($request->user_id);
        if ($user){
            if ($request->code == $user->code) {
                $this->userRepo->activateUser($user);
                \Auth::loginUsingId($user->id);
                return response()->json(['statue' => 0 , 'msg' => __('site.user_activated')]);
            }else{
                return response()->json(['statue' => 1 , 'msg' => __('site.code_wrong')]);
            }
        }else{
            return response()->json(['statue' => 2 , 'msg' => __('site.user_wrong')]);
        }
    }

    /***************** activate User *****************/
    public function resendCode($id)
    {
        $user = $this->userRepo->find($id);
        $this->userRepo->updateCode($user);
        return redirect(url('activate/'.$user->id));
    }
    /**************** logout *****************/
    public function logout()
    {
        auth()->guard()->logout();
//        session()->invalidate();
        session()->regenerateToken();
        return redirect()->back();
    }

    /**************** forgetPasswordPage *****************/
    public function forgetPasswordPage()
    {
        $countries = $this->CountryRepo->get() ;
        return view('site.auth.forget_password' ,compact('countries'));
    }
    /**************** forgetPassword *****************/
    public function forgetPassword(forgetPasswordRequest $request)
    {
        $user =  $this->userRepo->forgetPass($request->validated());
        return response()->json(['statue' => $user]);
    }
    /**************** forgetPasswordCodePage *****************/
    public function forgetPasswordCodePage($id)
    {
        return view('site.auth.forget_password_code' ,compact('id'));
    }

    /**************** forgetPasswordCode *****************/
    public function forgetPasswordCode(forgetPasswordCodeRequest $request)
    {
        $statue  =  $this->userRepo->forgetPassCode($request->validated());
        return response()->json(['statue' => $statue]);
    }
}
