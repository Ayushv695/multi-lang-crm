<?php

namespace App\Repositories;

use App\Models\Item;
use App\Models\ItemTranslation;
use App\Models\Language;
use App\Repositories\Contracts\ItemTranslationsRepositoryInterface;
use App\Traits\FileUpload;
use Illuminate\Http\Request;

class ItemTranslationsRepository implements ItemTranslationsRepositoryInterface
{
    use FileUpload;
    public function list(int $id){
        $translations = ItemTranslation::with(['item:id,name','language:id,name,code'])->where('item_id', $id)->get();
        $mappedLanguageIds = $translations->pluck('language_id')->toArray();

        $availableLanguages = Language::query()->select('id', 'name', 'code')->whereNotIn('id', $mappedLanguageIds)->get();

        return [
            'translations' => $translations,
            'languages_available_for_mapping' => $availableLanguages,
        ];
    }

    public function create(Request $request, array $data)
    {
        $data['created_by'] = auth()->user()->id;
        $data['photo'] = $this->uploadImage($request,'photo',Item::IMAGE_UPLOAD_PATH);
        return Item::create($data);
    }

    public function update(int $id , Request $request , array $data){
        $item = Item::findOrFail($id);
        $data['photo'] = $this->updateImage($request, $item, 'photo', Item::IMAGE_UPLOAD_PATH);
        $data['updated_by'] = auth()->user()->id;
        $item->update($data);
        return $item->fresh();
    }
    public function delete(int $itemId, int $languageId){
        $item = Item::findOrFail($id);
        // $this->deleteImage($item->photo , Item::IMAGE_UPLOAD_PATH);
        return (bool) $item->delete();
    }
}
