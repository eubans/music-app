import { ref } from "vue";
import axios from "axios";

import type { PlaylistEntity, SongsEntity } from "@/entities";

export const useMusic = () => {
    const playlists = ref<PlaylistEntity[]>();
    const playlist = ref<PlaylistEntity>();
    const songs = ref<SongsEntity[]>();

    /**
     * Fetch all playlists.
     *
     * @returns {Promise<PlaylistEntity[]>} A promise that resolves to an array of playlists.
     */
    const getPlaylists = (): Promise<PlaylistEntity[]> => {
        return new Promise(async (resolve, reject) => {
            await axios
                .get("api/playlists")
                .then((response) => {
                    resolve(response.data.data);
                })
                .catch(function (error) {
                    reject(error);
                });
        });
    };

    /**
     * Set songs.
     *
     * @param {SongsEntity[]} values The array of songs to set.
     * @returns {void}
     */
    const setSongs = (values: SongsEntity[]) => (songs.value = values);

    /**
     * Select the first playlist.
     *
     * @returns {Promise<void>} A promise that resolves when the first playlist is selected.
     */
    const selectPlaylist = async (): Promise<void> => {
        // Fetch and store all playlists.
        playlists.value = await getPlaylists();

        // Get and select the first playlist.
        if (playlists.value.length) {
            playlist.value = playlists.value[0];

            // Set songs from the selected playlist.
            setSongs(playlist.value.songs);
        }
    };

    return {
        playlists,
        playlist,
        songs,
        selectPlaylist,
    };
};
