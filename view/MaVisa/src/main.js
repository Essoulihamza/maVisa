import { createApp } from 'vue'
import {createRouter, createWebHistory} from 'vue-router'
import Home from '@/views/Home.vue'
import Regester from '@/views/Regester.vue'
import Tracking from '@/views/Tracking.vue'
import './style.css'
import App from './App.vue'

// 
// 
// 
const router = createRouter({
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

createApp(App)
App.use(router)
.mount('#app')
