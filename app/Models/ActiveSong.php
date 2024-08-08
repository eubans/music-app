<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActiveSong extends Model
{
    use HasFactory;

    /** @return BelongsTo */
    public function activePlaylist(): BelongsTo
    {
        return $this->belongsTo(ActivePlaylist::class);
    }

    /** @return HasOne */
    public function song(): HasOne
    {
        return $this->hasOne(Song::class);
    }
}
