<script setup lang="ts">
import { computed, toRefs } from "vue";
import { storeToRefs } from "pinia";
import { useStateStore } from "@/stores/useStateStore";
import { convertSecondsToTime } from "@/utils";

import MusicItem from "@/views/music/MusicItem.vue";
import MusicProgressSlider from "@/views/music/MusicProgressSlider.vue";

import IconPlay from "../../components/icons/IconPlay.vue";
import IconPause from "../../components/icons/IconPause.vue";
import IconShuffle from "../../components/icons/IconShuffle.vue";
import IconPrevious from "../../components/icons/IconPrevious.vue";
import IconNext from "../../components/icons/IconNext.vue";
import IconRandom from "../../components/icons/IconRandom.vue";

import type { SongsEntity } from "@/entities";

// Define the emit events for the MusicPanel component
interface MusicPanelEmits {
    (event: "toggle"): void;
    (event: "shuffle"): void;
    (event: "previous"): void;
    (event: "next"): void;
    (event: "random"): void;
}

// Define the props for the MusicPanel component
interface MusicPanelProps {
    song?: SongsEntity;
    currentTime?: number;
    duration?: number;
}

// Emit events setup
const emit = defineEmits<MusicPanelEmits>();

// Define default props values
const props = withDefaults(defineProps<MusicPanelProps>(), {
    currentTime: 0,
    duration: 100,
});
const { song } = toRefs(props);

// Extract state and actions from the store
const { play, shuffle, playing } = storeToRefs(useStateStore());
const { setPlay, setShuffle } = useStateStore();

const coverSrc = computed(() => {
    const cover = song.value?.cover ?? "default.png";

    return `${window.location.origin}/storage/songs/covers/${cover}`;
});

/**
 * Handle toggling the play state.
 */
const handleTogglePlay = () => {
    const state = !play.value;
    setPlay(state);
    emit("toggle");
};

/**
 * Handle toggling the shuffle state.
 */
const handleToggleShuffle = () => {
    const state = !shuffle.value;
    setShuffle(state);
    emit("shuffle");
};

/**
 * Emit the previous song event.
 */
const handlePrevious = () => emit("previous");

/**
 * Emit the next song event.
 */
const handleNext = () => emit("next");

/**
 * Emit the random song event.
 */
const handleRandom = () => emit("random");
</script>

<template>
    <div class="sm:basis-1/2">
        <div class="hidden sm:flex justify-center">
            <img class="object-cover w-1/2 rounded-xl" :src="coverSrc" />
        </div>

        <div class="flex justify-center my-8">
            <MusicItem
                v-if="song"
                :title="song.title"
                :artist="song.artist.name"
                center
                :time="false"
            />
        </div>

        <div class="px-16">
            <!-- Music progress slider -->
            <MusicProgressSlider :value="currentTime" :max="duration" />

            <!-- Display current time and duration -->
            <div class="flex justify-between mt-3 text-gray-400">
                <small>{{ convertSecondsToTime(currentTime) }}</small>
                <small>{{ convertSecondsToTime(duration) }}</small>
            </div>

            <!-- Music control buttons -->
            <div class="flex justify-between">
                <button title="Shuffle" @click="handleToggleShuffle">
                    <IconShuffle
                        :class="shuffle ? 'text-green-700' : 'text-gray-400'"
                        width="24"
                        height="24"
                    />
                </button>
                <button title="Previous" @click="handlePrevious">
                    <IconPrevious />
                </button>
                <button
                    :title="playing ? 'Pause' : 'Play'"
                    @click="handleTogglePlay"
                    class="text-black bg-gray-200 p-4 rounded-full"
                >
                    <IconPause v-if="playing" width="48" height="48" />
                    <IconPlay v-else width="48" height="48" />
                </button>
                <button title="Next" @click="handleNext">
                    <IconNext />
                </button>
                <button
                    title="Random Song"
                    @click="handleRandom"
                    :class="!playing && 'opacity-0 pointer-events-none'"
                >
                    <IconRandom class="text-gray-400" width="24" height="24" />
                </button>
            </div>
        </div>
    </div>
</template>
