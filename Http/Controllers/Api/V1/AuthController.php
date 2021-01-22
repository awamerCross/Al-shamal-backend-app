<?php

namespace App\Http\Controllers\Api\V1;
use JWTAuth;
use Carbon\Carbon;
use App\Models\User;
use App\Traits\Responses;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\IUser;
use App\Http\Resources\Api\UserResource;
use App\Http\Requests\Api\User\SignInRequest;
use App\Http\Requests\Api\User\ActivateRequest;
use App\Http\Requests\Api\User\EditProfileRequest;
use App\Http\Requests\Api\User\StoreUpdateRequest;
use App\Http\Requests\Api\User\UserUpgradeRequest;
use App\Http\Requests\Api\User\EditPasswordRequest;
use App\Http\Requests\Api\User\ResetPasswordRequest;
use App\Http\Requests\Api\User\UpdateProviderReuest;
use App\Http\Requests\Api\User\ForgetPasswordRequest;
use App\Http\Requests\Api\updatePhoneRequest ;
use App\Http\Requests\Api\updateEmailRequest ;

class AuthController extends Controller
{
    use     Responses;

    private $userRepository;
    public function __construct(IUser $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function signUp(StoreUpdateRequest $request)
    {
        $user   = $this->userRepository->signUp(array_filter($request->validated()));
        $token  = JWTAuth::fromUser($user);
        $user->update(['token' => $token]);
        $this->sendResponse(['token' => $token , 'code' => $user->code],__('auth.registered') );
    }

    public function activate(ActivateRequest $request){
         if(Carbon::parse(auth()->user()->code_expire)->isPast())
             $this->errorResponse([],trans('auth.code_expired'));

        if(auth()->user()->code == $request['code']){
            $this->userRepository->activateUser(auth()->user());
            $this->sendResponse(new UserResource(auth()->user()), __('auth.activated'));
        }
            $this->errorResponse([],trans('auth.code_invalid'));
    }

    public function resendCode(){
        $code = $this->userRepository->updateCode(auth()->user());
        $this->sendResponse(['code' => $code],__('auth.code_re_send') );
    }

    public function signIn(SignInRequest $request){
        if(is_numeric($request['phone'])){
            $array = ['key' => $request['key'],'phone' => $request['phone'], 'password' => $request['password'] , 'block' => 0];
            $array2 = ['key' => $request['key'],'phone' => $request['phone']];
        } elseif (filter_var($request['phone'], FILTER_VALIDATE_EMAIL)) {
            $array2 = ['email' => $request['phone']]  ;
            $array = ['email' => $request['phone'], 'password' => $request['password'] , 'block' => 0]  ;
        }
        $token = JWTAuth::attempt($array);
        if(!$token){
            $user = User::where($array2)->first() ;
            if (!$user) {
                $this->errorResponse(null,trans('auth.incorrect_key_or_phone'));
            }
            if ($user->block == 1 ) {
                $this->errorResponse(null, trans('site.blocked'));
            }
            $this->errorResponse(null,trans('auth.incorrect_pass_or_phone'));
        }

        if(auth()->user()->active == 0)
        {
            $code =  $this->userRepository->updateCode(auth()->user());
            $this->sendResponse(['token' => $token, 'code' => $code ,'value' => 1],__('auth.not_active') );
        }

        if($request['device_id'])
         $this->userRepository->updateDeviceId(auth()->user(), $request);
        
        $this->sendResponse(new UserResource(auth()->user()),__('apis.signed'));
    }

    public function forgetPassword(ForgetPasswordRequest $request){
        $data  = $this->userRepository->forgetPassword($request['phone'] ,$request->key);
        $this->sendResponse($data,__('auth.code_re_send') );
    }

    public function resetPassword(ResetPasswordRequest $request){
        $this->userRepository->update($request->validated()+['active' =>  1 , 'code' => null ],auth()->user());
        $this->sendResponse(new UserResource(auth()->user()),__('apis.passwordReset'));
    }

    public function editPassword(EditPasswordRequest $request){
        $this->userRepository->editPassword($request->validated());
        $this->sendResponse(new UserResource(auth()->user()),__('apis.updated'));
    }

    public function profile(){
        $this->sendResponse(new UserResource(auth()->user()));
    }

    public function updateProfile(EditProfileRequest $request){
        $this->userRepository->update($request->validated(),auth()->user());
        $this->sendResponse(new UserResource(auth()->user()) ,__('apis.updated'));
    }

    public function Logout(Request $request)
    {
        $token = $request->header('Authorization');
        try {
            $this->userRepository->deleteToken(auth()->id() , $request->device_id);
            JWTAuth::invalidate($token);
            return $this->sendResponse(null,trans('apis.loggedOut'));
        } catch (JWTException $e) {
            return $this->sendError(null,__('apis.something_wrong'));
        }
    }

    public function updatePhoneRequest(updatePhoneRequest $request)
    {
        $code =   $this->userRepository->updatePhoneRequest($request->validated());
        return $this->sendResponse(['code' => $code],trans('apis.send_activated'));
    }

    public function updatePhone()
    {
        $this->userRepository->updatePhone();
        return $this->sendResponse(new UserResource(auth()->user()),trans('apis.phone_changed'));
    }
    public function updateEmailRequest(updateEmailRequest $request)
    {
        $code =   $this->userRepository->updateEmailRequest($request->validated());
        return $this->sendResponse(['code' => $code],trans('apis.send_activated'));
    }

    public function updateEmail()
    {
        $this->userRepository->updateEmail();
        return $this->sendResponse(new UserResource(auth()->user()),trans('apis.email_changed'));
    }
}
