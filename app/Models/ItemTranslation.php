<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemTranslation extends Model
{
    protected $fillable = [
        'item_id',
        'language_id',
        'name',
        'audio',
        'status',
        'created_by',
        'updated_by',
    ];

    public const AUDIO_UPLOAD_PATH = 'uploads/audio/';
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    protected function getAudioUrlAttribute(){
        if($this->audio){
            return asset(self::AUDIO_UPLOAD_PATH.$this->audio);
        }
        return "";
    }
}
