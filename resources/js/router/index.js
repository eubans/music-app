import { createRouter, createWebHistory } from 'vue-router'

import MainView from '@/components/MainView.vue'

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
