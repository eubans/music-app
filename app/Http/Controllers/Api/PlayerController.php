<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SongResource;
use App\Http\Services\PlayerService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class PlayerController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param Request $request The HTTP request instance containing query parameters.
     * @param int $id The ID of the playlist to be played.
     * @return JsonResponse The response containing the collection of songs in the playlist.
     */
    public function play(Request $request, int $id)
    {
        $shuffle = $request->shuffle;
        $song = $request->song;

        $player = new PlayerService();
        $songs = $player->playPlaylist($id, $shuffle, $song);

        return SongResource::collection($songs)
            ->response()
            ->setStatusCode(JsonResponse::HTTP_OK);
    }
}
