<?php

namespace App\Repositories\Eloquent;

use App\Models\CommentReport;
use App\Repositories\Interfaces\ICommentReport;

class CommentReportRepository extends AbstractModelRepository implements ICommentReport
{
    public function __construct(CommentReport $model)
    {
        parent::__construct($model);
    }
 }
