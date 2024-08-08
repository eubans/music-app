<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PlaylistIndexRequest;
use App\Http\Resources\PlaylistResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use App\Models\Playlist;

class PlaylistController extends Controller
{
    /**
     * Return all playlists
     * @param PlaylistIndexRequest $request
     *
     * @return JsonResponse
     */
    public function index(PlaylistIndexRequest $request): JsonResponse
    {
        $playlists = Playlist::all();

        return PlaylistResource::collection($playlists)
            ->response()
            ->setStatusCode(JsonResponse::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
