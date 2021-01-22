<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\ICategory;


class categoryController extends Controller
{
    protected $categoryRepo;

    public function __construct(ICategory $categoryRepo)
    {
        $this->categoryRepo   = $categoryRepo;
    }

    public function selectCategory(){
        $categories = $this->categoryRepo->mainCategories();
        return view('site.ad.select_category',compact('categories'));
    }

    public function selectSubCategory($id){
        $categories = $this->categoryRepo->subcategories($id);
        $category   = $this->categoryRepo->find($id);
        return view('site.ad.select_sub_category',compact('categories','category'));
    }
}
