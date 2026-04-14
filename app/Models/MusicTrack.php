<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class MusicTrack extends Model
{
    protected $fillable = [
        'title',
        'url',
        'file_path',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active'  => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * URL pública del audio (archivo subido tiene prioridad sobre URL).
     */
    public function getAudioUrlAttribute(): ?string
    {
        if ($this->file_path) {
            return Storage::url($this->file_path);
        }
        return $this->url;
    }
}
