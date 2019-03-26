<template>
    <input type="checkbox"
        v-model="checked"
        @change="updateValue"
    >
</template>

<script>
export default {
    props: ['appointment'],
    data() {
        return {
            checked: this.appointment.asistencia
        }
    },
    methods: {
        updateValue() {
            // console.log(this.checked);
            axios.post('/', {id: this.appointment.id_cita})
            // .then(function(response) {
            //     console.log(response);
            // })
            .catch(function(error) {
                console.log(error);
            });
        }
    }
}
</script>
