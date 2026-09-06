<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemTranslationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'item_id' => $this->item_id,
            'item_name' => $this->item?->name,
            'language_id' => $this->language_id,
            'language_name' => $this->language?->name,
            'language_code' => $this->language?->code,
            'translated_name' => $this->name,
            'translated_audio' => $this->audio,
        ];
    }
}
