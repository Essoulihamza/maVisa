
const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/',
            name: 'Home',
            component: HomeView
        },
        {
            path: '/Regester',
            name: 'Regester',
            component: RegesterView
        },
        {
            path: '/Tracking',
            name: 'Tracking',
            component: TrackingView
        }

    ]
})