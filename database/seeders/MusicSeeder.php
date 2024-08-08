<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Playlist;
use App\Models\Artist;
use App\Models\Song;

class MusicSeeder extends Seeder
{
   /**
     * Run music seeder.
     *
     * @return void
     */
    public function run(): void
    {
        $playlistName = 'Playlist 1';

        // Created a collection from given playlist
        $songs = collect([
            [
                'artist' => 'Ed Sheeran',
                'title' => 'Shape of You',
                'file' => 'ed-sheeran-shape-of-you.mp3',
                'cover' => 'ed-sheeran-shape-of-you.png',
                'duration' => 235,
            ],
            [
                'artist' => 'Billie Eilish',
                'title' => 'Bad Guy',
                'file' => 'billie-eilish-bad-guy.mp3',
                'cover' => 'billie-eilish-bad-guy.png',
                'duration' => 194,
            ],
            [
                'artist' => 'Post Malone',
                'title' => 'Circles',
                'file' => 'post-malone-circles.mp3',
                'cover' => 'post-malone-circles.png',
                'duration' => 215,
            ],
            [
                'artist' => 'Taylor Swift',
                'title' => 'Shake It Off',
                'file' => 'taylor-swift-shake-it-off.mp3',
                'cover' => 'taylor-swift-shake-it-off.png',
                'duration' => 218,
            ],
            [
                'artist' => 'The Weeknd',
                'title' => 'Blinding Lights',
                'file' => 'the-weeknd-blinding-lights.mp3',
                'cover' => 'the-weeknd-blinding-lights.png',
                'duration' => 199,
            ],
            [
                'artist' => 'Ed Sheeran',
                'title' => 'Photograph',
                'file' => 'ed-sheeran-photograph.mp3',
                'cover' => 'ed-sheeran-photograph.png',
                'duration' => 258,
            ],
            [
                'artist' => 'Adele',
                'title' => 'Rolling in the Deep',
                'file' => 'adele-rolling-in-the-deep.mp3',
                'cover' => 'adele-rolling-in-the-deep.png',
                'duration' => 247,
            ],
            [
                'artist' => 'Post Malone',
                'title' => 'Sunflower',
                'file' => 'post-malone-sunflower.mp3',
                'cover' => 'post-malone-sunflower.png',
                'duration' => 193,
            ]
        ]);

        // Insert a playlist first
        $playlist = Playlist::create([
            'name' => $playlistName
        ]);

        // Then loop through song
        $songs->each(function (array $song, int $key) use ($playlist) {
            // Insert new if the artist does not exist
            $artist = Artist::firstOrCreate([
                'name' => $song['artist']
            ]);

            // Insert song
            Song::create([
                'title' => $song['title'],
                'playlist_id' => $playlist->id,
                'artist_id' => $artist->id,
                'file' => $song['file'],
                'cover' => $song['cover'],
                'duration' => $song['duration']
            ]);
        });
    }
}
