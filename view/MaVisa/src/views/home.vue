<template>
    <Header />
    <HookSection />
</template>


<script>
import Header from '../components/header.vue';
import HookSection from '../components/HookSection.vue';
export default {
    name: 'HomePage',
    components: {
        Header,
        HookSection,
    }
}
</script>