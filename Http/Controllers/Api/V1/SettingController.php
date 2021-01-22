<?php

namespace App\Http\Controllers\Api\V1;
use App;
use App\Traits\Responses;
use App\Http\Controllers\Controller;
use App\Http\Resources\BankResource;
use App\Repositories\Interfaces\IBank;
use App\Repositories\Interfaces\ISetting;
use App\Repositories\Interfaces\ITransfer;
use App\Http\Requests\Api\addTransferRequest;

class SettingController extends Controller
{
    use     Responses;


    private $settingRepository;
    private $bankRepository;
    private $transferRepository;

    public function __construct(ISetting $settingRepository,IBank $bankRepository,ITransfer $transferRepository)
    {
        $this->settingRepository  = $settingRepository;
        $this->bankRepository     = $bankRepository;
        $this->transferRepository = $transferRepository;
    }

    public function appInfo()
    {
        $this->sendResponse($this->settingRepository->contactInfo());
    }

    public function about()
    {
        $about = $this->settingRepository->getPage('about_'.lang()) ;
        $this->sendResponse($about);
    }
    public function addAdTerms()
    {
        $about = $this->settingRepository->getPage('add_ad_'.lang()) ;
        $this->sendResponse($about);
    }
    public function terms()
    {
        $about = $this->settingRepository->getPage('terms_'.lang()) ;
        $this->sendResponse($about);
    }
    public function commission()
    {
        $commission            = $this->settingRepository->getPage('commission_'.lang()) ;
        $commission_percentage = $this->settingRepository->getPage('commission_percentage') ;
        $data = [
            'commission'                  => $commission , 
            'banks'                       => BankResource::collection($this->bankRepository->get()) ,
            'commission_percentage'       => $commission_percentage , 
        ];
        $this->sendResponse($data);
    }

    public function banks()
    {
        $banks = BankResource::collection($this->bankRepository->get()) ;
        $this->sendResponse($banks);
    }
    public function addTransfer(addTransferRequest $request)
    {
        $this->transferRepository->store($request->validated()+(['user_id' => auth()->id()]));
        $this->sendResponse('',__('apis.transfered'));
    }







}

