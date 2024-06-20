import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import { createApp } from 'vue';
import router from './router'

import MainView from '@/components/MainView.vue';

createApp({
    components: {
        MainView
    }
}).use(router).mount('#app')
