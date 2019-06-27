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
            >
        </b-datepicker>
    </b-field>
</template>

<script>
import moment from 'moment';
export default {
    props:['label', 'name', 'old', 'error'],
    data(){
        return{
            date:null,
            inputColor:null,
            errorMessage:this.error
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
        }
    }
}
</script>

