<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\IAdReportReason;

class AdReportReasonController extends Controller
{
    protected $countryRepo;

    public function __construct(IAdReportReason $Country)
    {
        $this->countryRepo = $Country;
    }

    /***************************  get all  **************************/
    public function index()
    {
        $rows = $this->countryRepo->get();
        return view('admin.adreportreasons.index', compact('rows'));
    }

    /***************************  store  **************************/
    public function store(Request $request)
    {
        $this->countryRepo->store(array_filter($request->all()));
        return response()->json();
    }

    /***************************  update  **************************/
    public function update(Request $request, $id)
    {
        $country = $this->countryRepo->findOrFail($id);
        $this->countryRepo->update($request->all(),$country);
        return redirect()->back()->with('success', 'تم التعديل بنجاح');
    }

    public function destroy($id)
    {
        $country = $this->countryRepo->findOrFail($id);
        $this->countryRepo->softDelete($country);
        return redirect()->back()->with('success', 'تم الحذف بنجاح');
    }
}
