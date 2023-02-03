<template>
    <nav class="w-4/6 flex justify-between items-center">
        <ul class="flex w-1/2 justify-between">
            <li class="hidden text-green-900 hover:text-red-400 cursor-pointer md:block"><a href="">Home</a></li>
            <li class="hidden text-green-900 hover:text-red-400 cursor-pointer md:block"><a href="">AboutUs</a></li>
            <li class="hidden text-green-900 hover:text-red-400 cursor-pointer md:block"><a href="">ContactUs</a></li>
        </ul>
        <CallToActionButton text="Regester"/>
    </nav>
</template>

<script>
import CallToActionButton from './CallToActionButton.vue'

export default {
    name: 'DesktopNav',
    components: {
        CallToActionButton,
    }
}
</script>