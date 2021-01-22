<?php

namespace App\Models;

use App\Traits\UploadTrait;
use App\Models\FollowUp;
use App\Models\Rate;
use App\Models\Chat;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use UploadTrait;
    use SoftDeletes;

    public const ADMIN      = 1;
    public const USER       = 2;

    protected $guarded      = ['id'];

    protected $hidden       = [
        'password', 'remember_token',
    ];

    protected $fillable     = ['name','phone','email','password','hide_phone','avatar','role_id','user_type','device_id','code','token',
        'code_expire','active','latitude','longitude','address','city_id','country_id','is_notify','key','block'];



    // public function getAvatarAttribute($value)
    // {
    //     return url('public/storage/images/users/'.$value);
    // }

    public function setAvatarAttribute($value)
    {
        if ($value != null)
        {
            $this->attributes['avatar'] = $this->uploadAllTyps($value, 'users');
        }
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function role()
    {
        return $this->belongsTo(Role::class)->withTrashed();
    }
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }
    public function devices(){
        return $this->hasMany(UserToken::class);
    }

    public function isFollow(){
        return  FollowUp::where('follower_id',auth()->id())->where('followed_id',$this->id)->count();
    }

    public function countChat(){
        return Chat::where('r_id' ,auth()->id())->where('seen' ,0)->count();
    }

    public function isRate(){
        $rate =   Rate::where('user_id',auth()->id())->where('rated_id',$this->id)->first();
        if ($rate)
            return $rate->rate ;
        else
            return 0 ;
    }

     public function ads()
    {
        return $this->hasMany('App\Models\Ad', 'user_id', 'id');
    }
    public function activeAds()
    {
        return $this->hasMany('App\Models\Ad', 'user_id', 'id')->where('accepted' , 1);
    }
    public function notfications()
    {
        return $this->hasMany('App\Models\Ad', 'user_id', 'id');
    }
    public function photoAds()
    {
        return $this->hasMany('App\Models\PhotoAd', 'user_id', 'id');
    }
    public function activePhotoAds()
    {
        return $this->hasMany('App\Models\PhotoAd', 'user_id', 'id')->where('accepted' , 1);
    }

    public function faveorites()
    {
        return $this->hasMany('App\Models\Faveorite', 'user_id', 'id');
    }

    public function faveorites2()
    {
        return $this->belongsToMany(Ad::class, 'favorites');
    }

    public function rates()
    {
        return $this->hasMany('App\Models\Rate', 'rated_id', 'id');
    }

    public function rate()
    {
        return round($this->hasMany('App\Models\Rate', 'rated_id', 'id')->avg('rate'));
    }

    public function lastSeenAds()
    {
        return $this->hasMany('App\Models\LastSeen', 'user_id', 'id');
    }


    public function country()
    {
        return $this->belongsTo('App\Models\Country', 'country_id', 'id');
    }
    public function city()
    {
        return $this->belongsTo('App\Models\City', 'city_id', 'id');
    }


}
