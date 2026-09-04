<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'photo',
        'created_by',
        'updated_by',
    ];

    // protected $casts = [
    //     'status' => 'boolean',
    // ];

    public function translations()
    {
        return $this->hasMany(ItemTranslation::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
