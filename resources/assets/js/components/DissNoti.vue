<template>
<div v-if="visible">
    <div class="notification" :class="color">
        <button class="delete" @click="visible=false"></button>
        <slot></slot>
    </div>
</div>
</template>
<script>
export default {
    props: {
        color: { default: 'is-danger' },
    },
    data() {
        return {
            visible: true
        }
    }
}
</script>
