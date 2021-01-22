<?php

namespace App\Models;

use App\Traits\UploadTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Banner extends Model
{
    use HasTranslations;
    use UploadTrait;


    protected $fillable = ['title','icon'];

    public $translatable = ['title'];

    protected function asJson($value)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }

    public function setIconAttribute($value)
    {
        $this->attributes['icon'] = $this->uploadAllTyps($value, 'sliders');
    }
}
