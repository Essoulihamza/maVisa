<template>
    <header class="w-full flex justify-between py-4 px-12 bg-stone-400">
        <div>
            Mavisa-Logo
        </div>
        <nav>
            <ul class="space-x-6">
                <li v-for="page in pages">
                    <h1>11</h1>
                    <router-link :to="page.path">{{ page.name }}</router-link>
                </li>
            </ul>
        </nav>
    </header>
</template>

<script>
export default {
    name: 'Header',
    data(){
        return {
                pages: [
                {
                    path: '/',
                    name: 'Home'
                },
                {
                    path: '/Regester',
                    name: 'Regester',
                },
                {
                    path: '/Tracking',
                    name: 'Tracking'
                }
            ],
        }
    }
}
</script>