<?php

namespace App\Repositories\Eloquent;

use App\Models\Category;
use App\Traits\Responses;
use App\Traits\UploadTrait;
use App\Models\CategoryFeature;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Repositories\Interfaces\ICategory;

class CategoryRepository extends AbstractModelRepository implements ICategory
{

    use   UploadTrait;
    use   Responses;


    public function __construct(Category $model)
    {
        parent::__construct($model);
    }

    public function allCategories()
    {
        return $this->model->with('features')->latest()->get();
    }

    public function mainCategories()
    {
        return $this->model->with('features')->where('parent_id',null)->latest()->get();
    }
    public function mostSeen()
    {
        return $this->model->with('features')->where('parent_id',null)->orderBy('views' ,'DESC')->limit(2)->get();
    }
    public function mainCategories2()
    {
        return $this->model->with('features')->where('parent_id',null)->get();
    }

    public function subcategories($id)
    {
        return $this->model->with('features')->where('parent_id',$id)->latest()->get();
    }

    public function storeCategory($attributes=[])
    {
        $category = $this->store($attributes+(['identity' => $this->setName(str_replace(' ' ,'_',$attributes['name_ar']),str_replace(' ' ,'_',$attributes['name_en']))]));
        if(isset($attributes['features']))
        {
            foreach ($attributes['features'] as $key => $featuer)
            {
                CategoryFeature::UpdateOrCreate([
                    'category_id' => $category->id ,
                    'feature_id'  => $featuer,
                ]);
            }
        }
        return $category;
    }
    public function update($attributes = [],$category)
    {
        //update user
        $attributes['name']             = $this->setName($attributes['name_ar']            , $attributes['name_en']);
        $attributes['meta_title']       = $this->setName($attributes['meta_title_ar']      , $attributes['meta_title_en']);
        $attributes['meta_description'] = $this->setName($attributes['meta_description_ar'], $attributes['meta_description_en']);
        $attributes['meta_keywords']    = $this->setName($attributes['meta_keywords_ar']   , $attributes['meta_keywords_en']);
        $category->update($attributes);
        if(isset($attributes['features']))
        {
            CategoryFeature::where('category_id' ,$category->id)->delete();
            foreach ($attributes['features'] as $key => $featuer)
            {
                CategoryFeature::UpdateOrCreate([
                    'category_id' => $category->id ,
                    'feature_id'  => $featuer,
                ]);
            }
        }
        return $category;
    }

    public function plusViews($category)
    {
        $category->update(['views' => DB::raw('views+1')]);
        $parent =  $category->getAllParents()->first();
        if($parent)
          $parent->update(['views' => DB::raw('views+1')]);
        return ;
    }

 }
