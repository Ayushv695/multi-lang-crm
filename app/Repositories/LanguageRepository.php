<?php

namespace App\Repositories;

use App\Models\Language;
use App\Repositories\Contracts\LanguageRepositoryInterface;

class LanguageRepository implements LanguageRepositoryInterface
{
    public function list(array $data){
        $perPage = $data['per_page'] ?? 10;
        $search = $data['search'] ?? null;
        $query = Language::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('code', 'like', '%' . $search . '%');
            });
        }

        return $query->latest()->paginate($perPage)->withQueryString();
    }

    public function create(array $data)
    {
        return Language::create($data);
    }

    public function update(int $id, array $data){
        $language = Language::findOrFail($id);
        $language->update($data);
        return $language->fresh();
    }
    public function delete(int $id){
        return (bool) Language::findOrFail($id)->delete();
    }
}
