<?php

namespace App\Repositories\Eloquent;

use App\Models\AdComment;
use App\Repositories\Interfaces\IComment;

class CommentRepository extends AbstractModelRepository implements IComment
{
    public function __construct(AdComment $model)
    {
        parent::__construct($model);
    }
 }
