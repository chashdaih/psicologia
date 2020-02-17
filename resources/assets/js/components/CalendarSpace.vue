<template>
    <div @click="showModal" v-bind:class="{gray: taken}">
        <template v-if="appointment" style="background-color:#BEBEBE">
            <b class="is-size-7">Sup:</b>
            <p class="is-size-7">{{appointment.full_name}}</p>
        </template>
    </div>
</template>

<script>
import { eventBus } from '../app.js';
export default {
    props:{
        'appointment': {
            type: Object,
            default: null
        },
        'room': { type: String },
        'time': { type: String },
        'times': {
            type: Array,
            default: ['8:00:00', '9:00:00', '10:00:00', '11:00:00', '12:00:00', '13:00:00', '14:00:00', '15:00:00', '16:00:00', '17:00:00', '18:00:00', '19:00:00']
        }
    },
    data() {
        return {
            taken: false
        }
    },
    methods: {
        showModal() {
            if (this.appointment) {
                eventBus.$emit('cancel-modal', this.appointment);
            } else {
                // let times = ;
                eventBus.$emit('detail-modal', {room: this.room, time:this.times[this.time]});
            }
        }
    },
    mounted(){
        if(this.appointment) {
            this.taken = true;
        }
    }
}
</script>

<style scoped>
div {
    min-height: 7rem;
    padding-top: 5%;
    padding-left: 10%;
}
.gray {
    background-color: #BEBEBE;
}
</style>
