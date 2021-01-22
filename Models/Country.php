<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Country extends Model
{
    use HasTranslations;
    protected $fillable = ['name','key'];

    public $translatable = ['name'];

    protected function asJson($value)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }

    public function cities()
    {
        return $this->hasMany('App\Models\Cities', 'country_id', 'id');
    }

     public function ads()
    {
        return $this->hasMany('App\Models\Ad', 'country_id', 'id');
    }


}
