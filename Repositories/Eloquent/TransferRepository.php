<?php

namespace App\Repositories\Eloquent;

use App\Models\Transfer;
use App\Repositories\Interfaces\ITransfer;

class TransferRepository extends AbstractModelRepository implements ITransfer
{
    public function __construct(Transfer $model)
    {
        parent::__construct($model);
    }
 }
