import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import { createApp } from 'vue';
import { createPinia } from 'pinia';
import router from './router';

import MainView from '@/views/MainView.vue';

const pinia = createPinia();
const app = createApp({
    components: {
        MainView
    }
});
app.use(router);
app.use(pinia);
app.mount('#app');
