<?php

namespace App\Repositories;

use App\Models\Item;
use App\Repositories\Contracts\ItemRepositoryInterface;

class ItemRepository implements ItemRepositoryInterface
{
    public function list(array $data){
        $perPage = $data['per_page'] ?? 10;
        $search = $data['search'] ?? null;
        $query = Item::query();

        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        return $query->latest()->paginate($perPage);
    }

    public function create(array $data)
    {
        return Item::create($data);
    }

    public function update($id, array $data){
        $item = Item::findOrFail($id);
        $item->update($data);
        return $item->fresh();
    }
    public function delete($id){
        return (bool) Item::findOrFail($id)->delete();
    }
}
