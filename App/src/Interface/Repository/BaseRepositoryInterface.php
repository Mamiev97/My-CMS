<?php

namespace App\Interface\Repository;

interface BaseRepositoryInterface
{
    public function create(array $data): false|string;
    public function delete(int $id): bool;
    public function deleteByCriteria(array $criteria): bool;
    public function updateByCriteria(array $data, array $criteria): array;
}