<?php

namespace App\Repositories\Eloquent;

use App\Models\Role;
use App\Repositories\Interfaces\IRole;

class RoleRepository extends AbstractModelRepository implements IRole
{

    public function __construct(Role $model)
    {
        parent::__construct($model);
    }

    public function findOrFail($id)
    {
        return $this->model->with('permissions')->findOrFail($id);
    }


}
