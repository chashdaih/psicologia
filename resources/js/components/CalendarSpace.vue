<template>
    <div @click="showModal">
        <div class="inner" :style="myStyle" v-if="appointment">
            <b>Supervisor:</b>
            <p>{{ this.appointment }}</p>
        </div>
        <div class="inner available" v-else>

        </div>
    </div>
</template>

<script>
import { eventBus } from '../app.js';
export default {
    props:['appointment'],
    data() {
        return {
            myStyle: {
                // TODO depende si es para niños o adultos ¿computed?
            }
        }
    },
    methods: {
        showModal() {
            if (this.appointment) {
                eventBus.$emit('details-modal', this.appointment);
            }
        }
    },
    mounted(){
        console.log(this.appointment);
    }
}
</script>

<style scoped>
div {
    height: 100%;
    width: 100%;
    
}
.inner {
    padding-top: 5%;
    padding-left: 10%;
}
b,p {
    font-size: x-small;
}
</style>
