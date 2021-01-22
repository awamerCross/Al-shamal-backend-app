<?php

namespace App\Repositories\Eloquent;

use App\Models\Country;
use App\Repositories\Interfaces\ICountry;

class CountryRepository extends AbstractModelRepository implements ICountry
{
    public function __construct(Country $model)
    {
        parent::__construct($model);
    }
 }
