<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

interface ICategory extends IModelRepository
{
    public function allCategories();
    public function mainCategories();
    public function mostSeen();
    public function mainCategories2();
    public function subcategories($id);
    public function storeCategory($attributes=[]);
    public function update($attributes = [],$category);
    public function plusViews($category);
}
