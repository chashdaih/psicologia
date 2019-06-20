<template>
    <section>
        <b-field label="Busca por nombre, apellido o número de cuenta">
            <b-autocomplete
                rounded
                :data="data"
                placeholder="Busca por nombre, apellido o número de cuenta"
                :loading="isFetching"
                @typing="getAsyncData"
                @select="selected"
            >
                <template slot-scope="props">
                    <p>{{props.option.num_cuenta}} - {{props.option.full_name}}</p>
                </template>
            </b-autocomplete>
        </b-field>
    </section>
</template>

<script>
import debounce from 'lodash/debounce';
export default {
    props:['url',],
    data() {
        return {
            data: [],
            isFetching: false
        }
    },
    methods: {
        getAsyncData: debounce(function (term) {
            if (!term.length) {
                this.data = [];
                return;
            }
            this.isFetching = true;
            axios.get(this.url + '/partaker/search/' + term)
            .then(({data})=>{
                this.data = [];
                data.forEach(item=>this.data.push(item));
            })
            .catch(error=>{
                this.data = [];
                throw error;
            })
            .finally(()=>{this.isFetching = false})
        }, 500),
        selected(option) {
            console.log(option.num_cuenta);
            window.location.href = this.url + '/partaker/' + option.num_cuenta + '/edit';
        }
    }
}
</script>
