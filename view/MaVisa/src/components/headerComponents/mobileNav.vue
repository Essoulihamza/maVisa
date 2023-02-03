<template>
<div @click="toggleMenu" class="space-y-2 cursor-pointer md:hidden">
        <div class="w-8 h-0.5 bg-green-700"></div>
        <div class="w-8 h-0.5 bg-green-700"></div>
        <div class="w-8 h-0.5 bg-green-700"></div>
</div>
<nav id="mobile-nav" class="hidden absolute top-1/4 left-1/2  translate-x-[-50%] bg-gray-200 z-20 py-6 px-12  mx-2 rounded">
    <ul class="flex flex-col justify-between items-center w-full h-full space-y-6 mb-6">
        <li class="text-green-900 hover:text-red-400 cursor-pointer"><a href="">Home</a></li>
        <li class="text-green-900 hover:text-red-400 cursor-pointer "><a href="">AboutUs</a></li>
        <li class="text-green-900 hover:text-red-400 cursor-pointer "><a href="">ContactUs</a></li>
    </ul>
    <CallToActionButton text="Regester" />
</nav>
</template>

<script>
import CallToActionButton from './CallToActionButton.vue'
export default {
    name: 'MobileNav',
    components: {
        CallToActionButton,
    },
    methods: {
        toggleMenu() {
            let MobileNav = document.getElementById('mobile-nav');
            MobileNav.classList.toggle('hidden');
        }
    }
}
</script>