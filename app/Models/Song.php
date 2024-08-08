<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Song extends Model
{
    use HasFactory;

    /** @return BelongsTo */
    public function playlist(): BelongsTo
    {
        return $this->belongsTo(Playlist::class);
    }

    /** @return BelongsTo */
    public function artist(): BelongsTo
    {
        return $this->belongsTo(Artist::class);
    }
}
