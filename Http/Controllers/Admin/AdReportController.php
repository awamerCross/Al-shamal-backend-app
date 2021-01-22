<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\IAdReport;

class AdReportController extends Controller
{
    protected $Repo;

    public function __construct(IAdReport $Repo)
    {
        $this->Repo = $Repo;
    }


    /***************************  get all  **************************/
    public function index()
    {
        $rows = $this->Repo->get();
        return view('admin.adreports.index', compact('rows'));
    }


    public function destroy($id)
    {
        $reason = $this->Repo->findOrFail($id);
        $this->Repo->softDelete($reason);
        return redirect()->back()->with('success', 'تم الحذف بنجاح');
    }
}
