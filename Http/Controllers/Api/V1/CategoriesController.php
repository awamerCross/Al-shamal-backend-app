<?php

namespace App\Http\Controllers\Api\V1;

use App\Traits\Responses;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Repositories\Interfaces\ICategory;
use App\Http\Requests\Api\SubCategoriesRequest;

class CategoriesController extends Controller
{
    use     Responses;

    private $Repo;

    public function __construct(ICategory $Repo)
    {
        $this->Repo  = $Repo;
    }

    public function mainCategories()
    {
        $categories  =  CategoryResource::collection($this->Repo->mainCategories());
        $this->sendResponse($categories); 
    }

    public function subCategories(SubCategoriesRequest $request)
    {
        $categories = CategoryResource::collection($this->Repo->subcategories($request->category_id)); 
        $this->sendResponse($categories); 
    }

}
