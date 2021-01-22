<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryFeature extends Model
{
     protected $fillable = ['category_id','feature_id'];

    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id', 'id');
    }

    public function feature()
    {
        return $this->belongsTo('App\Models\Feature', 'feature_id', 'id');
    }
}
