<?php

namespace App\Repositories\Eloquent;

use App\Models\CommentReportReason;
use App\Repositories\Interfaces\ICommentReportReason;

class CommentReportReasonRepository extends AbstractModelRepository implements ICommentReportReason
{
    public function __construct(CommentReportReason $model)
    {
        parent::__construct($model);
    }
 }
