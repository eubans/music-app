<script setup lang="ts">
const props = defineProps({
    width: {
        type: String,
        required: false,
        default: "32",
    },
    height: {
        type: String,
        required: false,
        default: "32",
    },
});
</script>

<template>
    <svg
        xmlns="http://www.w3.org/2000/svg"
        :width="props.width"
        :height="props.width"
        viewBox="0 0 24 24"
    >
        <path fill="currentColor" d="M8 19V5l11 7z" />
    </svg>
</template>
