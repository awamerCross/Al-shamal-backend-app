<?php

namespace App\Repositories\Eloquent;

use App\Models\FollowUp;
use App\Traits\Responses;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Repositories\Interfaces\IFollowUp;

class FollowUpRepository extends AbstractModelRepository implements IFollowUp
{
    use   Responses;
    public function __construct(FollowUp $model)
    {
        parent::__construct($model);
    }

    public function followOrUnFollow($attributes = [])
    {
        $row = $this->model->where($attributes)->get();
        if ($row->count() > 0 )
        {
            $row->first()->delete() ;
            return 0 ;
        }else{
            $this->model->create($attributes);
            return 1 ;
        }
    }

    public function followers($id)
    {
        return $this->model->latest()->where('');
    }
    public function update($attributes = [],$user)
    {
        $user->update($attributes);
        return $user;
    }
}
