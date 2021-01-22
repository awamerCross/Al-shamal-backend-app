<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\ICommentReportReason;

class CommentReportReasonController extends Controller
{
    protected $Repo;

    public function __construct(ICommentReportReason $Repo)
    {
        $this->Repo = $Repo;
    }

    /***************************  get all  **************************/
    public function index()
    {
        $rows = $this->Repo->get();
        return view('admin.commentreportreasons.index', compact('rows'));
    }

    /***************************  store  **************************/
    public function store(Request $request)
    {
        $this->Repo->store(array_filter($request->all()));
        return response()->json();
    }

    /***************************  update  **************************/
    public function update(Request $request, $id)
    {
        $country = $this->Repo->findOrFail($id);
        $this->Repo->update($request->all(),$country);
        return redirect()->back()->with('success', 'تم التعديل بنجاح');
    }

    public function destroy($id)
    {
        $country = $this->Repo->findOrFail($id);
        $this->Repo->softDelete($country);
        return redirect()->back()->with('success', 'تم الحذف بنجاح');
    }
}
