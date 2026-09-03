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

        return $query->latest()->paginate($perPage);
    }

    public function create(array $data)
    {
        return Language::create($data);
    }

    public function update(Language $language, array $data){
        $language->update($data);
        return $language->fresh();
    }
    public function delete(Language $language){
        return (bool) $language->delete();
    }
}
