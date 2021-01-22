<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\IFeature;
use App\Repositories\Interfaces\ICategory;
use App\Http\Requests\Admin\Category\Create;

class CategoryController extends Controller
{
     protected $Repo;
     protected $FeatureRepo;

    public function __construct(ICategory $repo,IFeature $FeatureRepo)
    {
        $this->Repo = $repo;
        $this->FeatureRepo = $FeatureRepo;
    }

    /***************************  get all  **************************/
    public function index()
    {
        view()->share([
            'singleName' => 'قسم',
            'rows'       =>  $this->Repo->mainCategories(),
            'features'   =>  $this->FeatureRepo->get(),
            ]);
        return view('admin.categories.index');
    }


    /***************************  store  **************************/
    public function store(Create $request)
    {
        $this->Repo->storeCategory(array_filter($request->validated()));
        return response()->json();
    }
    /***************************  update  **************************/
    public function update(Create $request, $id)
    {
        $category = $this->Repo->findOrFail($id);
        $this->Repo->update($request->validated(),$category);
        return redirect()->back()->with('success', 'تم التعديل بنجاح');
    }

    public function destroy($id)
    {
        $category = $this->Repo->findOrFail($id);
        $this->Repo->softDelete($category);
        return redirect()->back()->with('success', 'تم الحذف بنجاح');
    }

    public function subCategories($id)
    {
        view()->share([
            'singleName' => 'قسم فرعي',
            'parent_id'  => $id,
            'parent'     => $this->Repo->findOrFail($id),
            'rows'       => $this->Repo->subcategories($id),
            'features'   => $this->FeatureRepo->get(),
            ]);
        return view('admin.categories.subs');
    }
}


