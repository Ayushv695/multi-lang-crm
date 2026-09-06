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
        $data['audio'] = $this->uploadFile($request,'audio',ItemTranslation::AUDIO_UPLOAD_PATH);
        return ItemTranslation::create($data);
    }

    public function update(int $id , Request $request , array $data){
        $translation = ItemTranslation::findOrFail($id);
        $data['audio'] = $this->updateFile($request, $translation, 'audio', ItemTranslation::AUDIO_UPLOAD_PATH);
        $data['updated_by'] = auth()->user()->id;
        $translation->update($data);
        return $translation->fresh();
    }

    public function delete(int $id){
        $translation = ItemTranslation::findOrFail($id);
        $this->deleteFile($translation->audio , ItemTranslation::AUDIO_UPLOAD_PATH);
        return (bool) $translation->delete();
    }
}
