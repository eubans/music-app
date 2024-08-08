<script setup lang="ts">
import { toRefs } from 'vue';
import Slider from "@vueform/slider";

// Define the props for the MusicProgressSlider component
interface MusicProgressSliderProps {
    value?: number;
    max?: number;
}

// Define default props values
const props = withDefaults(defineProps<MusicProgressSliderProps>(), {
    value: 0,
    max: 100,
});

// Convert the props to refs for reactivity
const { value, max } = toRefs(props);
</script>

<template>
    <div>
        <!-- Slider component from @vueform/slider -->
        <Slider v-model="value" :max="max" class="slider pointer-events-none" :tooltips="false" />
    </div>
</template>

<!-- Import default slider styles -->
<style src="@vueform/slider/themes/default.css" />

<style scoped>
.slider {
    --slider-bg: #9ca3af;
    --slider-height: 3px;
    --slider-handle-bg: #fff;
    --slider-connect-bg: #fff;
}
</style>
