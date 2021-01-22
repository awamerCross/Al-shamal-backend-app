<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class SiteSetting extends Model
{
//    use HasTranslations;
    protected $fillable = ['key', 'value'];
//    public $translatable = ['value'];

//    protected function asJson($value)
//    {
//        return json_encode($value, JSON_UNESCAPED_UNICODE);
//    }
}
