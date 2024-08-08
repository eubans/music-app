import { ref } from "vue";
import { defineStore } from "pinia";

export const useStateStore = defineStore("stateStore", () => {
    const play = ref<boolean>(false);
    const shuffle = ref<boolean>(false);
    const playing = ref<boolean>(false);

    /**
     * Set the play state.
     *
     * @param {boolean} state - The new play state.
     */
    const setPlay = (state: boolean) => (play.value = state);

    /**
     * Set the shuffle state.
     *
     * @param {boolean} state - The new shuffle state.
     */
    const setShuffle = (state: boolean) => (shuffle.value = state);

    /**
     * Set the playing state.
     *
     * @param {boolean} state - The new playing state.
     */
    const setPlaying = (state: boolean) => (playing.value = state);

    return { play, shuffle, playing, setPlay, setShuffle, setPlaying };
});
