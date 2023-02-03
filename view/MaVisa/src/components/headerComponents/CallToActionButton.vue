<template>
    <button class="px-4 py-1 bg-green-600 text-white rounded  hover:bg-green-900" >{{ text }}</button>
</template>

<script>
export default {
    name: 'CallToActionButton',
    props: {
        text: {
            type: String,
            default: "Call to action button",
        }
    }
}
</script>
