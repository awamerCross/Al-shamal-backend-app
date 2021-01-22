<?php

namespace App\Repositories\Eloquent;

use App\Models\AdReport;
use App\Repositories\Interfaces\IAdReport;

class AdReportRepository extends AbstractModelRepository implements IAdReport
{
    public function __construct(AdReport $model)
    {
        parent::__construct($model);
    }
 }
