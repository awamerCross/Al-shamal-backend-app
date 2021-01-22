<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\IBank;
use App\Repositories\Interfaces\ITransfer;
use App\Http\Requests\Site\UploadeCommissionRequest;


class BankController extends Controller
{
    protected $bankRepo;
    protected $transferRepo;

    public function __construct(IBank $bankRepo ,ITransfer $transferRepo)
    {
        $this->bankRepo       = $bankRepo;
        $this->transferRepo   = $transferRepo;
    }

    public function commission()
    {
        $banks = $this->bankRepo->get();
        return view('site.pages.commission',compact('banks'));
    }

    public function chooseBank()
    {
        $banks = $this->bankRepo->get();
        return view('site.pages.choose_bank',compact('banks'));
    }

    public function uploadCommissionPage($id)
    {
        $bank = $this->bankRepo->find($id);
        return view('site.pages.upload_commission',compact('bank'));
    }

    public function uploadCommission(UploadeCommissionRequest $request)
    {
        $this->transferRepo->store($request->validated()+(['user_id' => auth()->id()]));
        return response()->json();
    }
}
