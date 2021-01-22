<?php

namespace App\Repositories\Interfaces;

interface IRole extends IModelRepository
{
    public function findOrFail($id);
}

