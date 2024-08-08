<script setup lang="ts">
import { onMounted } from "vue";
import { useMusic } from "@/composables/useMusic";
import { usePlayer, Direction } from "@/composables/usePlayer";

import MusicList from "@/views/music/MusicList.vue";
import MusicItem from "@/views/music/MusicItem.vue";
import MusicPanel from "@/views/music/MusicPanel.vue";

import type { SongsEntity } from "@/entities";

// Destructure the necessary properties and methods from useMusic composable.
const { playlist, songs, selectPlaylist } = useMusic();
// Destructure the necessary properties and methods from usePlayer composable.
const {
    activeSong,
    currentTime,
    duration,
    initialize,
    togglePlay,
    toggleShuffle,
    changeSong,
    playRandom,
} = usePlayer();

/**
 * Handle selecting a song.
 *
 * @param {SongsEntity} song - The song to initialize and play.
 */
const handleSelectSong = (song: SongsEntity) =>
    initialize(playlist.value.id, song);

/**
 * Handle toggling play/pause state.
 */
const handleTogglePlay = () => {
    if (activeSong.value === undefined) {
        const firstSong = songs.value[0];
        handleSelectSong(firstSong);
    } else {
        togglePlay();
    }
};

/**
 * Handle toggling shuffle state.
 */
const handleToggleShuffle = () => toggleShuffle(playlist.value.id);

/**
 * Handle playing the previous song.
 */
const handlePreviousSong = () => changeSong(Direction.PREVIOUS);

/**
 * Handle playing the next song.
 */
const handleNextSong = () => changeSong(Direction.NEXT);

/**
 * Handle playing a random song.
 */
const handleRandomSong = () => playRandom();

/**
 * On component mount, select the playlist.
 */
onMounted(() => {
    selectPlaylist();
});
</script>

<template>
    <div class="container flex flex-col sm:flex-row-reverse w-full bg-primary text-white text-xl mx-auto">
        <MusicList>
            <MusicItem
                v-for="(song, songIndex) in songs"
                :key="`music-item-${songIndex}`"
                :title="song.title"
                :artist="song.artist.name"
                :duration="song.duration"
                :active="activeSong?.id === song.id"
                @click="handleSelectSong(song)"
            />
        </MusicList>

        <MusicPanel
            :song="activeSong"
            :current-time="currentTime"
            :duration="duration"
            @toggle="handleTogglePlay"
            @shuffle="handleToggleShuffle"
            @previous="handlePreviousSong"
            @next="handleNextSong"
            @random="handleRandomSong"
        />
    </div>
</template>
