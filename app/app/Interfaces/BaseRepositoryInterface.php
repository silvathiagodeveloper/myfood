<?php

namespace App\Interfaces;

interface BaseRepositoryInterface
{
    public function getAll();
    public function getAllPaginate(int $qtty = 15);
    public function getById(int $id);
    public function delete(int $id);
    public function create(array $details);
    public function update(int $id, array $newDetails);
}