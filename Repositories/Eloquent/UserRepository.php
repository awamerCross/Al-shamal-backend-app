<?php

namespace App\Repositories\Eloquent;

use App\Jobs\EmailAll;
use App\Jobs\EmailOne;
use App\Jobs\NotifyAll;
use App\Jobs\NotifyOne;
use App\Jobs\SmsAll;
use App\Models\User;
use App\Models\UserToken;
use App\Models\UserUpdate;
use App\Repositories\Interfaces\IUser;
use App\Services\UserService;
use App\Traits\UploadTrait;
use Hash;
use Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Traits\Responses;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserRepository extends AbstractModelRepository implements IUser
{

    use   UploadTrait;
    use   Responses;
    private $userToken ;
    private $userUpdate ;

    public function __construct(User $model,UserToken $userToken ,UserUpdate $userUpdate)
    {
        parent::__construct($model);
        $this->userToken = $userToken ;
        $this->userUpdate = $userUpdate ;
    }

    public function admins()
    {
        return $this->model->select('id', 'name', 'email', 'phone', 'block', 'avatar','role_id')->where('user_type', User::ADMIN)->latest()->get();
    }

    public function storeAdmin($attributes=[])
    {
        return $this->store($attributes+(['user_type'=>User::ADMIN]));
    }

    public function clients()
    {
        return $this->model->where('user_type', User::USER)->latest()->get();
    }

    public function storeClient($attributes=[])
    {
        return $this->store($attributes+(['user_type'=>User::USER]));
    }

    public function update($attributes = [],$user)
    {
        $user->update($attributes);
        return $user;
    }

    public function signIn($attributes = [])
    {
        $field = is_numeric($attributes['phone'])  ? 'phone' : 'email' ;

        if (auth()->guard()->attempt([ $field => $attributes['phone'], 'password' => $attributes['password'] ,'active' => 1])) {
            if (auth()->user()->block == 1 ){
                Auth::logout();
                return ['status' => 3 ];
            }
            return ['status' => 1 ];
        }else{
            if (auth()->guard()->attempt([ $field => $attributes['phone'], 'password' => $attributes['password']])){
                $user =  auth()->user()->update(['code' => 1111 , 'code_expire' => Carbon::now()->addMinute()]);
//                SmsAll::dispatch($user->phone , $user->key , __('site.activation_code_msg' , ['code' , $user->code]));
//                 EmailOne::dispatch($user->email  , $msg);
                Auth::logout();
                return ['status' => 2  , 'user_id' => $user->id] ;
            }
            return 0 ;
        }
    }


    public function signUp($request){
        $user = $this->store($request+(['user_type'=>User::USER ,'code' => 1111 , 'code_expire' => Carbon::now()->addMinute()])) ;
//        SmsAll::dispatch($user->phone , $user->key , __('site.activation_code_msg' , ['code' , $user->code]));
//        EmailOne::dispatch($user->email  , __('site.activation_code_msg' , ['code' , $user->code]));
        if (isset($request->device_id))
            $this->updateDeviceId($user,$request);

        return $user ;
    }



    public function activateUser($user){
         $user->update(['code' => null , 'code_expire' => null , 'active' => 1]);
         return ;
    }

    public function updateCode($user){
        $user->update(['code' => 1111 , 'code_expire' => Carbon::now()->addMinute() , 'active' => 0 ,  'token' => JWTAuth::fromUser($user)]);
        //        SmsAll::dispatch($user->phone , $user->key , __('site.activation_code_msg' , ['code' , $user->code]));
        return $user->code ;
    }


    public function updateDeviceId($user,$request){
        $user->update([ 'device_id' => $request['device_id'] , 'token' => JWTAuth::fromUser($user) ]);
        $request['user_id']    = $user->id;
        $this->userToken ::updateOrcreate( [
            'device_id'   => $request['device_id'],
            'device_type' => $request->device_type,
            'user_id'     => $user->id,
        ] );
    }

    public function forgetPass($attributes = [])
    {
        $user    = $this->model->where('phone',$attributes['phone'])->where('key' , $attributes['key'])->first();
        if (!$user) {
            return 0 ;
        }
        $update = $this->userUpdate->updateOrCreate([
            'user_id'       => $user->id,
            'type'          => 1,
        ],[
            'code'          => 1111,
        ]);
        $msg = 'كود التفعيل الخاص بك من تطبيق حراج هو : '. $update->code ;
        SmsAll::dispatch($update->phone , $update->code , $msg);
        return $user->id ;
    }

    public function forgetPassCode($attributes = [])
    {
        $update = $this->userUpdate->where([
            'user_id'    => $attributes['id'],
            'code'       => $attributes['code'],
            'type'       => 1,
        ])->get();

        if ($update->count()  == 0 )
        {
           return 0 ;
        }
        $user = $this->model->find($attributes['id']) ;
        $user->update(['password' => $attributes['password']]);
        $update->first()->delete();
        return 1 ;
    }

    public function forgetPassword($phone,$key){
      $user    = $this->model->where('phone',$phone)->where('key' , $key)->first();
      if (!$user) {
        $this->errorResponse([],trans('auth.incorrect_key_or_phone')); 
      }
      $this->updateCode($user);
      return ['token' => JWTAuth ::fromUser( $user) , 'code' => $user->code];
    }

    public function editPassword($request){
        if (!\Hash::check($request['old_password'], auth()->user()->password))
            $this->errorResponse([],trans('auth.incorrect_pass'));

        $this->model->whereId(auth()->id())->first()->update(['password' => $request['current_password'] ]);
    }
    
    public function messageOne($data, $type) : void
    {
        $user = $this->model::with('devices')->whereId($data['user_id'])->first();

        if($type === 'notification') {
            dispatch(new NotifyOne($user, $data));
        }
        elseif($type === 'email') {
            dispatch(new EmailOne($user->email, $data['message']));
        }
        elseif($type === 'sms') {
            dispatch(new SmsAll($user->phone, $data['message']));
        }

    }

    public function messageAll($data, $type) : void
    {

        if($type === 'notification') {
            $users = $this->model::with('devices')->where('user_type',$data['user_type'])->get();
            dispatch(new NotifyAll($users,$data));

        } elseif($type === 'email') {

            $emails = $this->model->select('email')->where('user_type',$data['user_type'])->pluck('email')->toArray();
            dispatch(new EmailAll($emails, $data['message']));

        } elseif($type === 'sms') {
            $phones = $this->model->select('phone')->where('user_type',$data['user_type'])->pluck('phone')->toArray();
            dispatch(new SmsAll($phones, $data['message']));
        }

     }

     public function block($client)
     {
         $client->block = 1 ;
         $client->save() ;
         return $client ;
     }


     public function updatePhoneRequest($data)
     {
        $update = $this->userUpdate->updateOrCreate([
            'user_id'       => auth()->id(),
            'type'          => 2,
            ],[
            'phone'         => $data['phone'],
            'newPhoneCode'  => $data['key'],
            'code'          => 1111,
        ]);
         $msg = 'كود التفعيل الخاص بك من تطبيق حراج هو : '. $update->code ;
         SmsAll::dispatch($update->phone , $update->code , $msg);
         return $update->code ;
     }

     public function updatePhone( $attributes = [])
     {
         if (isset($attributes['code'] )){
             $row  = $this->userUpdate->where(['user_id' => auth()->id() , 'type' => 2 ,'code' => $attributes['code'] ])->first() ;
             if (!$row){ return  $this->errorResponse([],['msg' => __('site.check_code') ,'status' => 0]);}
         }else{
             $row  = $this->userUpdate->where(['user_id' => auth()->id() , 'type' => 2 ])->first() ;
         }
         auth()->user()->update([
            'phone'   => $row->phone          ,
            'key'     => $row->newPhoneCode   ,
         ]);
         $row->delete();
         return ;
     }

     public function updateEmailRequest($data)
     {
        $update = $this->userUpdate->updateOrCreate([
            'user_id'       => auth()->id(),
            'type'          => 3,
            ],[
            'email'         => $data['email'],
//            'code'          => rand(1111,9999),
            'code'          => 1111,
        ]);
         $msg = 'كود التفعيل الخاص بك من تطبيق حراج هو : '. $update->code ;
//         EmailOne::dispatch($update->email  , $msg);
         return $update->code ;
     }

     public function updateEmail($attributes = [])
     {
         if (isset($attributes['code'] )){
             $row  = $this->userUpdate->where(['user_id' => auth()->id() , 'type' => 3 ,'code' => $attributes['code'] ])->first() ;
             if (!$row){ return  $this->errorResponse([],['msg' => __('site.check_code') ,'status' => 0]);}
         }else{
             $row  = $this->userUpdate->where(['user_id' => auth()->id() , 'type' => 3 ])->first() ;
         }
         auth()->user()->update([
            'email'   => $row->email          ,
         ]);
         $row->delete();
         return ;
     }


     public function sendAccountNumber($accountNumber)
     {
         $msg = 'رقم الحساب البنكي الذي طلبت ارساله هو : '. $accountNumber;
         SmsAll::dispatch(auth()->user()->phone , auth()->user()->key , $msg);
         return ;
     }

     public function deleteToken($user_id , $device_id)
     {
         $this->userToken ::where([
             'device_id'   => $device_id,
             'user_id'     => $user_id,
         ])->delete();
         return ;
     }
 }
