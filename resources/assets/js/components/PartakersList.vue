<template>
    <p>{{ res }}</p>
</template>
<script>
export default {
    props: [url],
    data() {
        return {
            data:null
        }
    },
    mounted() {
        axios.get()
    }
}
</script>
