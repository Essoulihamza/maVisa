<template>
    
</template>

<script>
import router from '@/router'
export default {
    mounted() {
        if(localStorage.getItem('token') != undefined) {
            localStorage.removeItem('token')
        }
        router.push('/')
    }
}
</script>
