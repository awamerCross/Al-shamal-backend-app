<?php

namespace App\Models;

use App\Traits\UploadTrait;
use App\Models\Feature;
use App\Models\Favorite;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Ad extends Model
{
     use HasTranslations;
    use UploadTrait;

    protected $fillable = ['title','description','icon','price','is_chat','is_phone','is_refresh','address','identity','meta_title',
    'meta_description','meta_keywords','accepted','active','latitude','longitude','country_id','city_id','category_id','user_id','phone','created_at'];
       
    public $translatable = ['title','description','meta_title','meta_description','meta_keywords','identity'];

    protected function asJson($value)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }

//    public function setIconAttribute($value)
//    {
//        $this->attributes['icon'] = $this->uploadAllTyps($value, 'products');
//    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopeAccepted($query)
    {
        return $query->where('accepted', 1);
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id', 'id');
    }

    public function country()
    {
        return $this->belongsTo('App\Models\Country', 'country_id', 'id');
    }

    public function city()
    {
        return $this->belongsTo('App\Models\City', 'city_id', 'id');
    }

    public function images()
    {
        return $this->hasMany('App\Models\AdImage', 'ad_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany('App\Models\AdComment', 'ad_id', 'id');
    }

     public function features2()
    {
        return $this->hasMany('App\Models\AdFeature', 'ad_id', 'id');
    }

    public function features()
    {
        return $this->belongsToMany(Feature::class, 'ad_features');
    }

    public function isFav($user_id){
        return  Favorite::where('user_id',$user_id)->where('ad_id',$this->id)->count();
    }
    public function image(){
        if ($this->images->count() > 0) {
            return $this->images->random()->image;
        }else{
            return 'default.png';
        }
    }

    public function reports()
    {
        return $this->hasMany('App\Models\AdReport', 'ad_id', 'id');
    }
}
