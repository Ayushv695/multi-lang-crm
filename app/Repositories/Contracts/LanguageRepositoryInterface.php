<?php

namespace App\Repositories\Contracts;

use App\Models\Language;

interface LanguageRepositoryInterface
{
    public function list(array $data);
    public function create(array $data);
    public function update(Language $language , array $data);
    public function delete(Language $language);
}
