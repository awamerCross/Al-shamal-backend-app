<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Repositories\Interfaces\ICategory;
use App\Repositories\Interfaces\IAd;
use App\Repositories\Interfaces\ICountry;
use App\Repositories\Interfaces\ICity;
//use App\Http\Requests\Admin\Ad\Create;

class HomeController extends Controller
{
    protected $categoryRepo;
    protected $adRepo;
    protected $countryRepo;
    protected $cityRepo;

    public function __construct(ICategory $categoryRepo, IAd $adRepo , ICountry $countryRepo, ICity $cityRepo)
    {
        $this->categoryRepo       = $categoryRepo;
        $this->adRepo             = $adRepo;
        $this->countryRepo        = $countryRepo;
        $this->cityRepo           = $cityRepo;
    }


    public function index()
    {
        $mostSeen       = $this->categoryRepo->mostSeen();
        $mainCategories = $this->categoryRepo->mainCategories();
        $countries      = $this->countryRepo->get();
        $cities         = $this->cityRepo->get();
        $ads            = $this->adRepo->acceptedAdsPaginate();
        return view('site.home.index',compact('mainCategories' ,'ads','countries' ,'cities' ,'mostSeen'));
    }

    public function getCategoriesChildes(Request $request)
    {
        $category          =  $this->categoryRepo->find($request->category_id) ;
        if ($category) {
            $this->categoryRepo->plusViews($category);
            $subCategoriesAll = $category->childes;
            if ($subCategoriesAll->count() > 0) {
                $subCategories = view('site.shared.sub_categories', ['mode' => 1, 'childes' => $subCategoriesAll ,'category' => $request->category_id])->render();
                $subCategoriesIcons = view('site.shared.sub_categories', ['mode' => 0, 'childes' => $subCategoriesAll])->render();
            } else {
                $subCategories = null;
                $subCategoriesIcons = null;
            }
        }else{
            $subCategories =  view('site.shared.sub_categories', ['mode' => 1, 'childes' => $this->categoryRepo->mainCategories() ,'category' => $request->category_id])->render();
            $subCategoriesIcons = view('site.shared.sub_categories', ['mode' => 0, 'childes' => $this->categoryRepo->mainCategories()])->render();
        }
        return response()->json(['subCategories' => $subCategories ,'subCategoriesIcons' => $subCategoriesIcons]);
    }


    public function category($id)
    {
        $countries      = $this->countryRepo->get();
        $cities         = $this->cityRepo->get();
        $category       = $this->categoryRepo->find($id);
        $ads            = $this->adRepo->filterAds(['category_id' => $id]);
        return view('site.category.index' ,compact('countries' ,'cities' ,'category' ,'ads'));
    }
}
