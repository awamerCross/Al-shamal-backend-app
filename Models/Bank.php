<?php

namespace App\Models;

use App\Traits\UploadTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Bank extends Model
{
     use HasTranslations;
     use UploadTrait;


    protected $fillable = ['name','account_name','account_number','iban','icon'];

    public $translatable = ['name'];

    protected function asJson($value)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }

    public function getIconAttribute($value)
    {
        return url('public/storage/images/banks/'.$value);
    }

    public function setIconAttribute($value)
    {
        $this->attributes['icon'] = $this->uploadAllTyps($value, 'banks');
    }
}
