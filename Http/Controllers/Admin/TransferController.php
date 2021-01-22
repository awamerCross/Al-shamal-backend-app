<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\ITransfer;

class TransferController extends Controller
{
    protected $repo;

    public function __construct(ITransfer $repo)
    {
        $this->repo = $repo;
    }

    /***************************  get all  **************************/
    public function index()
    {
        $rows = $this->repo->get(['user']);
        return view('admin.transfers.index', compact('rows'));
    }


    public function destroy($id)
    {
        $transfer = $this->repo->findOrFail($id);
        $this->repo->softDelete($transfer);
        return redirect()->back()->with('success', 'تم الحذف بنجاح');
    }
}
