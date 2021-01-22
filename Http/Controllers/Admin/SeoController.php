<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\ISeo;
use App\Http\Requests\Admin\Seo\Create;

class SeoController extends Controller
{
     protected $repo;

    public function __construct(ISeo $repo)
    {
        $this->repo = $repo;
    }

    /***************************  get all  **************************/
    public function index()
    {
        $rows = $this->repo->get();
        return view('admin.seos.index', compact('rows'));
    }

    /***************************  store  **************************/
    public function store(Create $request)
    {
        $this->repo->store(array_filter($request->validated()));
        return response()->json();
    }

    /***************************  update  **************************/
    public function update(Create $request, $id)
    {
        $seo = $this->repo->findOrFail($id);
        $this->repo->update($request->validated(),$seo);
        return redirect()->back()->with('success', 'تم التعديل بنجاح');
    }

    public function destroy($id)
    {
        $bank = $this->repo->findOrFail($id);
        $this->repo->softDelete($bank);
        return redirect()->back()->with('success', 'تم الحذف بنجاح');
    }

}
