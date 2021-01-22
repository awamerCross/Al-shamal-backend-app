<?php

namespace App\Repositories\Eloquent;

use App\Jobs\EmailAll;
use App\Jobs\EmailOne;
use App\Jobs\NotifyAll;
use App\Jobs\NotifyOne;
use App\Jobs\SmsAll;
use App\Models\Provider;
use App\Models\User;
use App\Models\UserToken;
use App\Models\Wallet;
use App\Models\Delegate;
use App\Repositories\Interfaces\IUser;
use App\Services\UserService;
use App\Traits\UploadTrait;
use Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Traits\Responses;
use Tymon\JWTAuth\Facades\JWTAuth;

class User2Repository extends AbstractModelRepository implements IUser2
{

    use   UploadTrait;
    use   Responses;


    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function admins()
    {
        return $this->model->select('id', 'name', 'email', 'phone', 'block', 'avatar','role_id')->where('user_type', User::ADMIN)->latest()->get();
    }

    public function storeAdmin($attributes=[])
    {
        return $this->store($attributes+(['user_type'=>User::ADMIN]));
    }

    public function store($attributes = [])
    {
        return  DB::transaction(function ()   use ($attributes) {

            $user = $this->model->create($attributes);

            // upload if delegate
            if($attributes['user_type'] == User::DELEGATE)
                $user->delegate()->create(UserService::setAddDelegate($attributes));

            // create provider
            if($attributes['user_type'] == User::PROVIDER){
                $attributes['restaurant_name'] = $this->setName($attributes['restaurant_name_ar'],$attributes['restaurant_name_en']);
                $user->provider()->create($attributes);
            }

            return $user;
        });
    }
    
    public function update($attributes = [],$user)
    {
        //delete old avatar
        if (isset($attributes['avatar']))
            if ($user->avatar != 'user.png')
                $this->deleteFile($user->avatar, 'users');

        //update user
        $user->update($attributes);

        // update  delegate
        if($user->user_type == User::DELEGATE)
            $user->delegate()->update($attributes);

        // update provider
        if($user->user_type == User::PROVIDER){
            $attributes['restaurant_name'] = $this->setName($attributes['restaurant_name_ar'],$attributes['restaurant_name_en']);
            $user->provider->update($attributes);
        }

        return $user;
    }
 }
