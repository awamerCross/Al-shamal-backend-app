<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Feature extends Model
{
     use HasTranslations;

    protected $fillable = ['name','icon','numeric'];

    public $translatable = ['name'];

    protected function asJson($value)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }

     public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_features');
    }
}
