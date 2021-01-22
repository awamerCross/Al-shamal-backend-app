<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Seo extends Model
{
     use HasTranslations;

    protected $fillable = ['key','meta_title','meta_description','meta_keywords'];

    public $translatable = ['meta_title','meta_description','meta_keywords'];

    protected function asJson($value)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }
}
