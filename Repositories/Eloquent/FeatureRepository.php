<?php

namespace App\Repositories\Eloquent;

use App\Models\Feature;
use App\Repositories\Interfaces\IFeature;

class FeatureRepository extends AbstractModelRepository implements IFeature
{
    public function __construct(Feature $model)
    {
        parent::__construct($model);
    }
 }
