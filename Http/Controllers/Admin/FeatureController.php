<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\IFeature;
use App\Http\Requests\Admin\Feature\Create;

class FeatureController extends Controller
{
    protected $Repo;

    public function __construct(IFeature $repo)
    {
        $this->Repo = $repo;
    }

    /***************************  get all  **************************/
    public function index()
    {
        view()->share([
            'singleName' => 'مميزات',
            'rows'       =>  $this->Repo->get(),
            ]);
        return view('admin.features.index');
    }

    /***************************  store  **************************/
    public function store(Create $request)
    {
        $this->Repo->store(array_filter($request->validated()));
        return response()->json();
        // return redirect()->back()->with('success', 'added successfully');
    }

    /***************************  update  **************************/
    public function update(Create $request, $id)
    {
        $city = $this->Repo->findOrFail($id);
        $this->Repo->update($request->validated(),$city);
        return redirect()->back()->with('success', 'تم التعديل بنجاح');
    }

    public function destroy($id)
    {
        $country = $this->Repo->findOrFail($id);
        $this->Repo->softDelete($country);
        return redirect()->back()->with('success', 'تم الحذف بنجاح');
    }
}
