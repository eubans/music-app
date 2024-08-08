<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SongResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'        => $this->resource->id,
            'title'     => $this->resource->title,
            'playlist'  => PlaylistShortResource::make($this->resource->playlist),
            'artist'    => ArtistShortResource::make($this->resource->artist),
            'file'      => $this->resource->file,
            'cover'     => $this->resource->cover,
            'duration'  => $this->resource->duration,
        ];
    }
}
