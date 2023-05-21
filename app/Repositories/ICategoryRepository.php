<?php

namespace App\Repositories;

interface ICategoryRepository
{
    public function findById(int $id);
    public function create(array $attributes);
    public function update(array $attributes, int $id);
    public function deleteById(int $id);
    public function paginate(int $itemPerPage);
    public function searchAndPaginate(string $escapedKeyword, int $itemPerPage);
    public function listAll(array $columns = ['*'], bool $withDeleted = false);
}
