import {createRouter, createWebHistory} from 'vue-router'
import Home from '@/views/Home.vue'
import Regester from '@/views/Regester.vue'
import Tracking from '@/views/Tracking.vue'


export const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/',
            name: 'Home',
            component: Home
        },
        {
            path: '/Regester',
            name: 'Regester',
            component: Regester
        },
        {
            path: '/Tracking',
            name: 'Tracking',
            component: Tracking
        }

    ]
})


