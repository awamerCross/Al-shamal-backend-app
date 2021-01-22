<?php

namespace App\Repositories\Eloquent;

use App\Models\AdReportReason;
use App\Repositories\Interfaces\IAdReportReason;

class AdReportReasonRepository extends AbstractModelRepository implements IAdReportReason
{
    public function __construct(AdReportReason $model)
    {
        parent::__construct($model);
    }
 }
