<?php

namespace App\Repositories\Contracts;

interface LanguageRepositoryInterface
{
    public function list(array $data);
    public function create(array $data);
    public function update($id , array $data);
    public function delete($id);
}
