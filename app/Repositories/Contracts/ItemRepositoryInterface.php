<?php

namespace App\Repositories\Contracts;

use Illuminate\Http\Request;

interface ItemRepositoryInterface
{
    public function list(array $data);
    public function create(Request $request, array $data);
    public function update($id, Request $request, array $data);
    public function delete($id);
}
