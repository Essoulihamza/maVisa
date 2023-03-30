import { createApp, ref } from 'vue'
import { createPinia } from 'pinia'
import { router } from '@/router/index.js'
import '@/style.css'
import App from '@/App.vue'


const pinia = createPinia();

const app = createApp(App)
app.use(router)
app.use(pinia)
app.use(ref)
app.mount('#app')
