import { onUnmounted, ref, nextTick } from "vue";
import axios from "axios";
import { storeToRefs } from "pinia";

import { useStateStore } from "@/stores/useStateStore";

import type { SongsEntity } from "@/entities";

export enum Direction {
    PREVIOUS = "previous",
    NEXT = "next",
}

interface PlayAndListTracksRequest {
    shuffle?: boolean;
    song?: boolean;
}

const STORAGE_PATH = "/storage/songs";

export const usePlayer = () => {
    const audio = ref<HTMLAudioElement>(new Audio());
    const activeSong = ref<SongsEntity>();
    const orderedSongs = ref<SongsEntity[]>([]);
    const interval = ref<ReturnType<typeof setInterval>>();
    const currentTime = ref<number>(0);
    const duration = ref<number>(100);

    const { play: playState, shuffle: shuffleState } = storeToRefs(
        useStateStore()
    );
    const { setPlaying } = useStateStore();

    /**
     * Fetches the list of tracks to be played and their order from the server.
     *
     * @param {number} id - The playlist ID.
     * @param {boolean} shuffle - Whether to shuffle the playlist.
     * @param {boolean} songId - The ID of the song to start playing from.
     * @returns {SongsEntity[]} A promise that resolves to an array of songs.
     */
    const playAndListTracks = (
        id: number,
        shuffle = undefined,
        songId = undefined
    ): Promise<SongsEntity[]> => {
        const payload: PlayAndListTracksRequest = {
            shuffle: shuffle === undefined ? shuffleState.value : shuffle,
        };

        if (songId) payload.song = songId;

        return new Promise(async (resolve, reject) => {
            await axios
                .post(`api/player/play/${id}`, payload)
                .then((response) => {
                    resolve(response.data.data);
                })
                .catch(function (error) {
                    reject(error);
                });
        });
    };

    /**
     * Resolves the full file path for a given file.
     *
     * @param {string} file - The file name.
     * @returns {string} The full URL to the file.
     */
    const resolveFilePath = (file: string) =>
        `${window.location.origin}${STORAGE_PATH}/${file}`;

    /**
     * Attaches a source URL to the audio element.
     *
     * @param {string} src - The source URL.
     */
    const attachSource = (src: string) => (audio.value.src = src);

    /**
     * Plays the audio.
     */
    const play = () => {
        audio.value.play();
        setPlaying(true);
    };

    /**
     * Pauses the audio.
     */
    const pause = () => {
        audio.value.pause();
        setPlaying(false);
    };

    /**
     * Clear the duration interval and reset the duration and current time values.
     */
    const clearDuration = () => {
        clearInterval(interval.value);
        duration.value = 100;
        currentTime.value = 0;
    };

    /**
     * Set the duration for the current song and start an interval to update the current time.
     *
     * @param {number} max - The duration of the song in seconds.
     */
    const setDuration = (max: number) => {
        clearDuration();
        duration.value = max;

        interval.value = setInterval(() => {
            currentTime.value++;
        }, 1000);
    };

    /**
     * Initializes the player with a playlist and a song.
     *
     * @param {number} id - The playlist ID.
     * @param {SongsEntity} song - The song to start playing.
     */
    const initialize = async (id: number, song: SongsEntity) => {
        const filePath = resolveFilePath(song.file);

        activeSong.value = song;
        orderedSongs.value = await playAndListTracks(id);

        attachSource(filePath);
        setDuration(song.duration);
        play();
    };

    /**
     * Toggles play/pause state of the audio.
     */
    const togglePlay = () => {
        if (audio.value.paused && !playState.value) {
            play();
        } else {
            pause();
        }
    };

    /**
     * Finds the index of the currently active song in the ordered songs list.
     *
     * @returns {SongsEntity} The index of the active song.
     */
    const findSongIndex = () =>
        orderedSongs.value.findIndex(
            (song: SongsEntity) => song.id === activeSong.value.id
        );

    /**
     * Changes the currently active song to the next or previous one based on direction.
     *
     * @param {Direction} direction - The direction to change the song (next or previous).
     */
    const changeSong = (direction: Direction) => {
        const activeIndex = findSongIndex();

        let index = activeIndex + (direction === Direction.NEXT ? 1 : -1);

        if (orderedSongs.value[index] === undefined) {
            index =
                direction === Direction.NEXT
                    ? 0
                    : orderedSongs.value.length - 1;
        }

        const song = orderedSongs.value[index];
        if (song) {
            activeSong.value = song;
            const filePath = resolveFilePath(song.file);
            attachSource(filePath);
            setDuration(song.duration);
            play();
        }
    };

    /**
     * Toggles the shuffle state and updates the ordered songs list accordingly.
     *
     * @param {number} id - The playlist ID.
     */
    const toggleShuffle = async (id: number) => {
        orderedSongs.value = await playAndListTracks(id, shuffleState.value);
    };

    /**
     * Play a random song from the ordered songs list.
     */
    const playRandom = () => {
        const song =
            orderedSongs.value[
                Math.floor(Math.random() * orderedSongs.value.length)
            ];
        activeSong.value = song;
        const filePath = resolveFilePath(song.file);
        attachSource(filePath);
        setDuration(song.duration);
        play();
    };

    /**
     * Cleans up resources when the composable is unmounted.
     */
    onUnmounted(() => {
        attachSource("");
        clearInterval(interval.value);
    });

    return {
        activeSong,
        currentTime,
        duration,
        initialize,
        togglePlay,
        changeSong,
        toggleShuffle,
        playRandom,
    };
};
