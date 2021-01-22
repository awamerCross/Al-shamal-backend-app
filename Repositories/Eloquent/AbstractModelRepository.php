<?php


namespace App\Repositories\Eloquent;

use App\Repositories\Interfaces\IModelRepository;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractModelRepository implements IModelRepository
{
    CONST PAGE_SIZE=15;
    public $model;

    /**
     * AbstractModelRepository constructor.
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function get($with = [])
    {
        return $this->model->with($with)->latest()->get();
    }

    public function getAsc($with = [])
    {
        return $this->model->with($with)->get();
    }

    public function select($array)
    {
        return $this->model->latest()->select($array)->get();
    }

    public function store($attributes = [])
    {
        if (!empty($attributes)) {

            if (isset($attributes['name_ar']) && isset($attributes['name_en']))
                $attributes['name'] = $this->setName($attributes['name_ar'], $attributes['name_en']);

            if (isset($attributes['title_ar']) && isset($attributes['title_en']))
                $attributes['title'] = $this->setName($attributes['title_ar'], $attributes['title_en']);

            if (isset($attributes['description_ar']) && isset($attributes['description_ar']))
                $attributes['description'] = $this->setName($attributes['description_ar'], $attributes['description_en']);

            if (isset($attributes['meta_title_ar']) && isset($attributes['meta_title_en']))
                $attributes['meta_title'] = $this->setName($attributes['meta_title_ar'], $attributes['meta_title_en']);

            if (isset($attributes['meta_description_ar']) && isset($attributes['meta_description_en']))
                $attributes['meta_description'] = $this->setName($attributes['meta_description_ar'], $attributes['meta_description_en']);

            if (isset($attributes['meta_keywords_ar']) && isset($attributes['meta_keywords_en']))
                $attributes['meta_keywords'] = $this->setName($attributes['meta_keywords_ar'], $attributes['meta_keywords_en']);

            return $this->model->create($attributes);
        } else
            return false;
    }


    public function find($id)
    {
        return $this->model->find($id);
    }


    public function update($attributes =[], Model $model)
    {
        if (!empty($attributes)) {
            if (isset($attributes['name_ar']) && isset($attributes['name_en']))
                $attributes['name'] = $this->setName($attributes['name_ar'], $attributes['name_en']);

            if (isset($attributes['title_ar']) && isset($attributes['title_en']))
                $attributes['title'] = $this->setName($attributes['title_ar'], $attributes['title_en']);

            if (isset($attributes['description_ar']) && isset($attributes['description_ar']))
                $attributes['description'] = $this->setName($attributes['description_ar'], $attributes['description_en']);

            if (isset($attributes['meta_title_ar']) && isset($attributes['meta_title_en']))
                $attributes['meta_title'] = $this->setName($attributes['meta_title_ar'], $attributes['meta_title_en']);

            if (isset($attributes['meta_description_ar']) && isset($attributes['meta_description_en']))
                $attributes['meta_description'] = $this->setName($attributes['meta_description_ar'], $attributes['meta_description_en']);

            if (isset($attributes['meta_keywords_ar']) && isset($attributes['meta_keywords_en']))
                $attributes['meta_keywords'] = $this->setName($attributes['meta_keywords_ar'], $attributes['meta_keywords_en']);

            $model->update($attributes);
            return $this->model;
        }
        return $this->model;
    }

    public function softDelete(Model $model)
    {
        return $model->delete();
    }


    public function delete($id)
    {
        if (!is_array($id))
            $id = (array)$id;

        return $this->model->whereIn('id', (array)$id)->delete();
    }


    public function findOrFail($id)
    {
        return $this->model->findOrFail($id);
    }

     public function whereIn($ids)
    {
        return $this->model->whereIn('id' ,$ids)->get();
    }

    public function search($request)
    {
        return $this->model->where('name', 'like', '%' . $request['word'] . '%')->latest()->get();
    }

    public function setName($name_ar, $name_en): array
    {
        return ['en' => $name_en, 'ar' => $name_ar];
    }
}
