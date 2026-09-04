<?php

namespace App\Repositories\Contracts;

interface LanguageRepositoryInterface
{
    public function list(array $data);
    public function create(array $data);
    public function update(int $id , array $data);
    public function delete(int $id);
}
