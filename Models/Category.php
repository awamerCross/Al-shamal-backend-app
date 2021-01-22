<?php

namespace App\Models;

use App\Traits\UploadTrait;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Collection;

class Category extends Model
{
    use HasTranslations;
    use UploadTrait;


    protected $fillable = ['name','icon','level','parent_id','identity','meta_title','meta_description','meta_keywords' ,'views'];
       
    public $translatable = ['name','identity','meta_title','meta_description','meta_keywords'];

    public function features()
    {
        return $this->belongsToMany(Feature::class, 'category_features');
    }
       
    protected function asJson($value)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }

    // public function getIconAttribute($value)
    // {
    //     return url('public/storage/images/categories/'.$value);
    // }


    public function setIconAttribute($value)
    {
        $this->attributes['icon'] = $this->uploadAllTyps($value, 'categories');
    }

    public function childes(){
        return $this->hasMany(self::class,'parent_id');
    }

    public function parent(){
         return $this->belongsTo(self::class,'parent_id');
    }


    public function subChildes()
    {
         return $this->childes()->with( 'subChildes' );
    }

    public function subParents()
    {
        return $this -> parent()->with('subParents');
    }

    public function getAllChildren ()
    {
        $sections = new Collection();
        foreach ($this->childes as $section) {
            $sections->push($section);
            $sections = $sections->merge($section->getAllChildren());
        }
        return $sections;
    }

    public function getMostSeenChildrens ()
    {
        $sections = new Collection();
        foreach ($this->childes as $section) {
            $sections->push($section);
            $sections = $sections->merge($section->getAllChildren());
        }

        $ids = $section->pluck('id')->toArray();
        $catefories = Category::whereIn('id',$ids)->orderBy('views','DESC')->limit(4)->get();
        return $catefories ;
    }

    public function getAllParents()
    {
        $parents = collect([]);

        $parent = $this->parent;

        while(!is_null($parent)) {
            $parents->prepend($parent);
            $parent = $parent->parent;
        }
        return $parents;
    }

    public function getFullPath(){
        $parents  = $this->getAllParents () ;
        $current  = Category::where('id',$this->id)->get();
        $parents  = $parents->merge($current);
        $childs   = $this->getAllChildren () ;
        $path     = $childs->merge($parents);
        return $path ;
    }

    public function ads()
    {
        return $this->hasMany('App\Models\Ad', 'category_id', 'id');
    }

}
