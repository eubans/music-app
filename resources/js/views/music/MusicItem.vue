<script setup lang="ts">
import { computed } from "vue";
import { storeToRefs } from "pinia";
import { useStateStore } from "@/stores/useStateStore";
import { convertSecondsToTime } from "@/utils";
import IconPlay from "../../components/icons/IconPlay.vue";
import IconPause from "../../components/icons/IconPause.vue";

// Define the emit events for the MusicItem component
interface MusicItemEmits {
    (event: "toggle"): void;
}

// Define the props for the MusicItem component
interface MusicItemProps {
    title: string;
    artist: string;
    duration?: number;
    active?: boolean;
    center?: boolean;
    time?: boolean;
}

// Emit events setup
const emit = defineEmits<MusicItemEmits>();

// Define default props values
const props = withDefaults(defineProps<MusicItemProps>(), {
    duration: 0,
    active: false,
    center: false,
    time: true,
});

// Extract state from the store
const { playing } = storeToRefs(useStateStore());

// Compute classes based on the center prop
const classes = computed(() => [
    props.center ? "text-center" : "justify-between",
]);
</script>

<template>
    <div class="flex" :class="classes">
        <div class="flex">
            <!-- Play/Pause button when the song is active -->
            <button v-if="active && playing" class="mr-2 bg-slate-700 rounded-full w-10 h-10">
                <IconPause v-if="playing" width="18" height="18" class="w-full" />
                <IconPlay v-else width="18" height="18" class="w-full" />
            </button>
            <!-- Song title and artist -->
            <div class="flex flex-col">
                <span>{{ title }}</span>
                <small class="text-gray-400">{{ artist }}</small>
            </div>
        </div>
        <!-- Display song duration if time prop is true -->
        <span v-if="time">{{ convertSecondsToTime(duration) }}</span>
    </div>
</template>
