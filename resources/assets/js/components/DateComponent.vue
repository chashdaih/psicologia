<template>
    <b-field :label="label"
        :type="inputColor"
        :message="errorMessage"
        >
        <b-datepicker
            :name="name"
            placeholder="Haz click para seleccionar la fecha"
            icon-pack="fas"
            icon="calendar"
            v-model="date"
            :date-formatter="formatter"
            @input="cleanError"
            :min-date="minDate"
            :max-date="maxDate"
            :years-range="[-120, 120]"
            >
        </b-datepicker>
    </b-field>
</template>

<script>
import moment from 'moment';
export default {
    props:['label', 'name', 'old', 'error'],
    data(){
        const today = new Date();
        return{
            date:null,
            inputColor:null,
            errorMessage:this.error,
            minDate: new Date(today.getFullYear()-120, today.getMonth(), today.getDate()),
            maxDate: today
        }
    },
    mounted() {
        if (this.old) {
            this.date = moment(this.old).toDate();
        }
        if(this.error) {
            this.inputColor = 'is-danger'
        }
    },
    methods: {
        formatter(d) {
            return moment(d).format('YYYY-MM-DD');
        },
        cleanError() {
            this.errorMessage = null;
            this.inputColor = null;
            this.$emit('date-change', this.date);
        },
    }
}
</script>

