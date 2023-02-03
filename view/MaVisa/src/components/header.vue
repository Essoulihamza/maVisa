<template>
    <header class="flex justify-between items-center px-8 py-2  md:py-4 md:px-16 bg-gray-200 h-[10vh]">
        <h3 class="text-2xl text-red-400 border-l-2 border-green-900 pl-3 cursor-pointer" ><span class="text-green-900" >Ma</span>Visa</h3>
        <DesktopNav class="hidden md:flex"  />
        <MobileNav />
    </header>
</template>

<script>
import DesktopNav from './headerComponents/DesktopNav.vue';
import MobileNav from './headerComponents/mobileNav.vue'
export default {
    name: 'Header',
    components: {
        DesktopNav,
        MobileNav,
    }
}
</script>