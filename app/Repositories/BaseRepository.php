<?php

namespace App\Repositories;

use Illuminate\Support\Collection;
use App\Repositories\Interfaces\BaseRepositoryInterface;

abstract class BaseRepository implements BaseRepositoryInterface
{

    public function getById(int $id)
    {
        return $this->model->find($id);
    }

    public function all()
    {
        return $this->model->all();
    }

    public function getByAttribute(string $field, string $attribute)
    {
        return $this->model->where($field, $attribute);
    }

    /**
     * {@inheritDoc}
     */
    public function getByAttributeIn(string $field, array $attributes): Collection
    {
        return $this->model->whereIn($field, $attributes)->get();
    }

    public function store(array $data)
    {
        return $this->model->create($data);
    }

    public function updateById(array $data, int $id)
    {
        return $this->model->where('id', $id)
            ->update($data);
    }

    public function delete(int $id)
    {
        return $this->model->where('id', $id)
            ->delete();
    }

    public function getWithRelation(string $relation)
    {
        return $this->model->with($relation)->get();
    }

    public function getByIdAndWithRelations(int $id, array $relations)
    {
        return $this->model->where('id', $id)->with($relations);
    }

    public function insert(array $values)
    {
        return $this->model->insert($values);
    }
}