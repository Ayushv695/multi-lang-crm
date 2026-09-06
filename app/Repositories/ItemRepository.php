<?php

namespace App\Repositories;

use App\Models\Item;
use App\Models\ItemTranslation;
use App\Repositories\Contracts\ItemRepositoryInterface;
use App\Traits\FileUpload;
use Illuminate\Http\Request;

class ItemRepository implements ItemRepositoryInterface
{
    use FileUpload;
    public function list(array $data){
        $perPage = $data['per_page'] ?? 10;
        $search = $data['search'] ?? null;
        $query = Item::query();

        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        return $query->latest()->paginate($perPage)->withQueryString();
    }

    public function create(Request $request, array $data)
    {
        $data['created_by'] = auth()->user()->id;
        $data['photo'] = $this->uploadFile($request,'photo',Item::IMAGE_UPLOAD_PATH);
        return Item::create($data);
    }

    public function update(int $id , Request $request , array $data){
        $item = Item::findOrFail($id);
        $data['photo'] = $this->updateFile($request, $item, 'photo', Item::IMAGE_UPLOAD_PATH);
        $data['updated_by'] = auth()->user()->id;
        $item->update($data);
        return $item->fresh();
    }
    public function delete(int $id){
        $item = Item::findOrFail($id);

        foreach ($item->translations as $translation) {
            if ($translation->audio) {
                $this->deleteFile(
                    $translation->audio,
                    ItemTranslation::AUDIO_UPLOAD_PATH
                );
            }
        }

        $item->translations()->delete();

        $this->deleteFile($item->photo , Item::IMAGE_UPLOAD_PATH);
        return (bool) $item->delete();
    }

    public function allItemslist(){
        return Item::select('id','name')->get();
    }
}
