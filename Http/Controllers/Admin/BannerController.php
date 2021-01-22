<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Repositories\Interfaces\IBanner;
use App\Http\Requests\Admin\Banner\Create;
use App\Http\Requests\Admin\Banner\Update;

class BannerController extends Controller
{
    protected $repo;

    public function __construct(IBanner $repo)
    {
        $this->repo = $repo;
    }

    /***************************  get all  **************************/
    public function index()
    {
        $rows = $this->repo->get();
        return view('admin.banners.index', compact('rows'));
    }

    /***************************  store  **************************/
    public function store(Create $request)
    {
        $this->repo->store(array_filter($request->validated()));
        return response()->json();
    }

    /***************************  update  **************************/
    public function update(Update $request, $id)
    {
        $banner = $this->repo->findOrFail($id);
        $this->repo->update($request->validated(),$banner);
        return redirect()->back()->with('success', 'تم التعديل بنجاح');
    }

    public function destroy($id)
    {
        $banner = $this->repo->findOrFail($id);
        $this->repo->softDelete($banner);
        return redirect()->back()->with('success', 'تم الحذف بنجاح');
    }
}
