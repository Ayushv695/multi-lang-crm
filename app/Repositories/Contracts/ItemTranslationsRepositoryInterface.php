<?php

namespace App\Repositories\Contracts;

use Illuminate\Http\Request;

interface ItemTranslationsRepositoryInterface
{
    public function list(int $id);
    public function create(Request $request, array $data);
    public function update(int $id, Request $request, array $data);
    public function delete(int $itemId, int $languageId);
}
