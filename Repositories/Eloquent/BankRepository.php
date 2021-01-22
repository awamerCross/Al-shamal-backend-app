<?php

namespace App\Repositories\Eloquent;

use App\Models\Bank;
use App\Repositories\Interfaces\IBank;

class BankRepository extends AbstractModelRepository implements IBank
{
    public function __construct(Bank $model)
    {
        parent::__construct($model);
    }
 }
