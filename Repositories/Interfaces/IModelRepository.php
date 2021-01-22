<?php


namespace App\Repositories\Interfaces;


use Illuminate\Database\Eloquent\Model;

interface IModelRepository
{

    public function find($id);

    public function findOrFail($id);

    public function delete($id);

    public function get();

    public function store($attributes = []);

    public function update($attributes = [], Model $model);

    public function softDelete(Model $model);


}
