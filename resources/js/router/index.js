import { createRouter, createWebHistory } from 'vue-router'

import MainView from '@/views/MainView.vue'

const routes = [
    {
        path: '/dashboard',
        name: 'dashboard',
        component: MainView
    }
];

export default createRouter({
    history: createWebHistory(),
    routes
})
