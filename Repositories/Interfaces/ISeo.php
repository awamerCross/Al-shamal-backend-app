<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

interface ISeo extends IModelRepository
{
    public function seoRow($key);
}
