<template>
    <b-field :label="label" >
        <b-datepicker
            :name="name"
            placeholder="Haz click para seleccionar la fecha"
            icon-pack="fas"
            icon="calendar"
            v-model="date"
            :date-formatter="formatter"
            >
        </b-datepicker>
    </b-field>
</template>

<script>
import moment from 'moment';
export default {
    props:['label', 'name', 'old'],
    data(){
        return{
            date:null
        }
    },
    mounted() {
        if (this.old) {
            this.date = new Date(this.old);
        }
    },
    methods: {
        formatter(d) {
            return moment(d).format('YYYY-MM-DD');
        }
    }
}
</script>

