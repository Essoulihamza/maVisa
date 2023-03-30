import {createRouter, createWebHistory} from 'vue-router'
import Home from '@/views/Home.vue'
import Register from '@/views/Register.vue'
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
            path: '/Register',
            name: 'Register',
            component: Register
        },
        {
            path: '/Tracking',
            name: 'Tracking',
            component: Tracking
        }

    ]
})


