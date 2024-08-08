<?php

namespace App\Http\Services;

use Illuminate\Support\Collection;

use App\Models\Playlist;
use App\Models\Song;
use App\Models\ActivePlaylist;
use App\Models\ActiveSong;

class PlayerService
{
    /**
     * @TODO Write a unit test for this service layer
     */

    /**
     * Overwrites the current playlist with new songs and sets an active song if provided.
     *
     * @param int $playlistId The ID of the playlist to be overwritten.
     * @param array $songs An array of songs to be added to the playlist.
     * @param int|null $activeSongId The ID of the song to be set as active, if any.
     * @return void
     */
    private function overwrite(int $playlistId, array $songs, int|null $activeSongId = null): void
    {
        /**
         * @TODO
         * Truncate table can be removed when the application supports multiple playlist selection.
         * The logic also needs to be updated.
         */

        // Prepare the payload with playlist ID and optional active song ID.
        $payload = array(
            'playlist_id' => $playlistId
        );
        if ($activeSongId) $payload['song_id'] = $activeSongId;

        // Truncate the ActivePlaylist table and create a new active playlist record.
        $playlist = ActivePlaylist::truncate()->create($payload);

        // Prepare the payload for the songs to be inserted into the ActiveSong table.
        $songsPayload = array();
        collect($songs)->each(function (array $song, int $key) use (&$songsPayload, $playlist) {
            $songsPayload[] = [
                'active_playlist_id' => $playlist->id,
                'song_id' => $song['id'],
            ];
        });

        // Truncate the ActiveSong table and insert the new songs.
        ActiveSong::truncate()->insert($songsPayload);
    }

    /**
     * Shuffles the songs collection ensuring no two consecutive songs have the same artist.
     *
     * @param Collection $songs The collection of songs to be shuffled.
     * @param int|null $activeSongId The ID of the song to be set as active, if any (not used in this function).
     * @return Collection The shuffled collection of songs.
     */
    private function shuffle(Collection $songs, int|null $activeSongId = null): Collection
    {
        // Shuffle the songs randomly.
        $shuffled = $songs->shuffle();

        // Initialize a new collection for rearranged songs and a variable to track the last artist.
        $rearranged = collect();
        $lastArtist = null;

        // Rearrange the songs to ensure no two consecutive songs have the same artist.
        while ($shuffled->isNotEmpty()) {
            $index = $shuffled->search(function (Song $song) use ($lastArtist) {
                return $song->artist_id !== $lastArtist;
            });

            if ($index === false) {
                // If no song found with a different artist, reshuffle and start over.
                $shuffled = $shuffled->shuffle();
                $rearranged = collect();
                $lastArtist = null;
            } else {
                // Pull the song from the shuffled collection and add it to the rearranged collection.
                $song = $shuffled->pull($index);
                $rearranged->push($song);
                $lastArtist = $song->artist_id;
            }
        }

        return $rearranged;
    }

    /**
     * Plays the specified playlist, optionally shuffling the songs and setting an active song.
     *
     * @param string $playlistId The ID of the playlist to be played.
     * @param bool $shuffle Whether to shuffle the songs in the playlist.
     * @param int|null $activeSongId The ID of the song to be set as active, if any.
     * @return Collection The collection of songs in the playlist, shuffled if specified.
     */
    public function playPlaylist(string $playlistId, bool $shuffle = false, int|null $activeSongId = null): Collection
    {
        // Find the playlist by its ID.
        $playlist = Playlist::findOrFail($playlistId);

        // Get the songs from the playlist.
        $songs = $playlist->songs;

        // Shuffle the songs if specified.
        if ($shuffle) $songs = $this->shuffle($songs);

        // Overwrite the current active playlist with the new songs and optional active song ID.
        $this->overwrite($playlist->id, $songs->toArray(), $activeSongId);

        return $songs;
    }
}

