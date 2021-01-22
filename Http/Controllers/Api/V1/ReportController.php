<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\Responses;
use App\Repositories\Interfaces\ICommentReportReason;
use App\Repositories\Interfaces\IAdReportReason;
use App\Repositories\Interfaces\IAdReport;
use App\Repositories\Interfaces\ICommentReport;
use App\Http\Resources\AdReportReasonResource;
use App\Http\Resources\CommentReportReasonResource;
use App\Http\Requests\Api\addAdReportRequest;
use App\Http\Requests\Api\addCommentReportRequest;


class ReportController extends Controller
{
    use     Responses;

    private $AdReportReason;
    private $CommentReportReason;
    private $AdReport;
    private $CommentReport;

    public function __construct(IAdReportReason $AdReportReason ,ICommentReportReason $CommentReportReason ,IAdReport $AdReport ,ICommentReport $CommentReport)
    {
        $this->AdReportReason        = $AdReportReason;
        $this->CommentReportReason   = $CommentReportReason;
        $this->AdReport              = $AdReport;
        $this->CommentReport         = $CommentReport;
    }

    public function reportReasons()
    {
        $data = [
          'adReasons'       => AdReportReasonResource::collection($this->AdReportReason->get()) ,
          'commentReasons'  => CommentReportReasonResource::collection($this->AdReportReason->get()) ,
        ];
        $this->sendResponse($data);
    }

    public function addAdReport(addAdReportRequest $request)
    {
       $this->AdReport->store($request->validated()+(['user_id' => auth()->id()]));
       $this->sendResponse('' , __('apis.reportAdded'));
    }

    public function addCommentReport(addCommentReportRequest $request)
    {
       $this->CommentReport->store($request->validated()+(['user_id' => auth()->id()]));
       $this->sendResponse('' , __('apis.reportAdded'));
    }
}
