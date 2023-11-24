<?php

namespace App\Repositories\Interfaces;

use Illuminate\Support\Collection;

interface BaseRepositoryInterface 
{
    public function getById(int $id);
    public function all();
    public function getByAttribute(string $field, string $attribute);

    /**
     * @param  string  $field
     * @param  array  $attribute
     * @return Collection
     */
    public function getByAttributeIn(string $field, array $attribute): Collection;

    public function store(array $data);
    public function updateById(array $data, int $id);
    public function delete(int $id) ;
    public function getWithRelation(string $relation);
    public function getByIdAndWithRelations(int $id, array $relations);
    public function insert(array $values);
}