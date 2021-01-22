<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\IBank;
use App\Http\Requests\Admin\Bank\Create;
use App\Http\Requests\Admin\Bank\Update;

class BankController extends Controller
{
    protected $repo;

    public function __construct(IBank $repo)
    {
        $this->repo = $repo;
    }
    /***************************  get all  **************************/
    public function index()
    {
        $rows = $this->repo->get();
        return view('admin.banks.index', compact('rows'));
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
        $bank = $this->repo->findOrFail($id);
        $this->repo->update($request->validated(),$bank);
        return redirect()->back()->with('success', 'تم التعديل بنجاح');
    }
    /***************************  destroy  **************************/
    public function destroy($id)
    {
        $bank = $this->repo->findOrFail($id);
        $this->repo->softDelete($bank);
        return redirect()->back()->with('success', 'تم الحذف بنجاح');
    }
}
