<template>
    <div class="flex flex-col justify-center items-center bg-green-700 h-[90vh] relative">
        <div class="text-center text-white space-y-3 z-10">
            <h1 class="text-3xl md:text-7xl font-bold">WELCOME TO MaVisa</h1>
            <p>Your partner in Morocco for all your visa applications for USA</p>
        </div>
        <img src="../assets/svg/airplan.svg" alt="hook svg" class="absolute top-1/2 left-1/2 translate-y-[-50%] translate-x-[-50%] opacity-30">
    </div>
</template>

<script>
import CallToActionButton from './headerComponents/CallToActionButton.vue'
export default {
  components: { CallToActionButton },
    name: 'Hooksection',
}
</script>