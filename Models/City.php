<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class City extends Model
{
     use HasTranslations;

    protected $fillable = ['name','country_id'];

     public $translatable = ['name'];

    protected function asJson($value)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }

    public function country()
    {
        return $this->belongsTo('App\Models\Country', 'country_id', 'id');
    }

     public function ads()
    {
        return $this->hasMany('App\Models\Ad', 'city_id', 'id');
    }

}
