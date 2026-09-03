<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\ItemRepositoryInterface;

class ItemRepository implements ItemRepositoryInterface
{
    public function create(array $data)
    {
        return User::create($data);
    }
}
