<?php

namespace App\Repositories\Eloquent;

use App\Models\Seo;
use App\Repositories\Interfaces\ISeo;

class SeoRepository extends AbstractModelRepository implements ISeo
{

    public function __construct(Seo $model)
    {
        parent::__construct($model);
    }

    public function seoRow($key)
    {
        return $this->model->where('key' , $key )->first();
    }

 }
