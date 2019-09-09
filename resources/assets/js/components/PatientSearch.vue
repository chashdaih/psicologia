<template>
    <section>
        <b-field label="Busca por nombre o número de expediente">
            <b-autocomplete
                rounded
                :data="data"
                placeholder="Busca por nombre o número de expediente"
                :loading="isFetching"
                @typing="getAsyncData"
                @select="selected"
            >
                <template slot-scope="props">
                    <p>{{props.option.file_number}} - {{props.option.full_name}}</p>
                </template>
            </b-autocomplete>
        </b-field>
        <br>
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
            axios.get(this.url + '/search/' + term)
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
            window.location.href = this.url  + '/' + option.id ;
        }
    }
}
</script>