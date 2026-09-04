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

            'language_id' => $this->language_id,

            'language' => $this->whenLoaded(
                'language',
                fn () => [
                    'id' => $this->language->id,
                    'name' => $this->language->name,
                    'code' => $this->language->code,
                ]
            ),

            'name' => $this->name,

            'audio' => $this->audio,

            'audio_url' => $this->audio
                ? asset('storage/' . $this->audio)
                : null,

            'status' => $this->status,

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
