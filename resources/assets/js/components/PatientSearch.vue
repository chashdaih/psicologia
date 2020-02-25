<template>
    <section>
        <div class="field">
            <label class="label">Centro</label>
            <div class="control">
                <div class="select">
                <select v-model="selectedCenter" :disabled="centers.length < 2">
                    <option v-for="center in centers" :key="center.id_centro" :value="center.id_centro">{{ center.siglas }}</option>
                </select>
                </div>
            </div>
        </div>
        <div class="field">
            <label class="label">Año</label>
            <div class="control">
                <div class="select">
                <select v-model="selectedYear" :disabled="years.length < 2">
                    <option v-for="year in years" :key="year" :value="year">{{ year }}</option>
                </select>
                </div>
            </div>
        </div>
        <b-field label="Busca por número de expediente">
            <b-autocomplete
                rounded
                :data="data"
                placeholder="Busca por número de expediente"
                :loading="isFetching"
                @typing="getAsyncData"
                @select="selected"
            >
                <template slot-scope="props">
                    <p>{{props.option.siglas}} - {{props.option.file_year}} - {{props.option.file_number}} - {{props.option.full_name}}</p>
                </template>
            </b-autocomplete>
        </b-field>
        <br>
    </section>
</template>

<script>
import debounce from 'lodash/debounce';
export default {
    props:['url','years', 'centers'],
    data() {
        return {
            selectedYear: this.years[0],
            selectedCenter: this.centers[0].id_centro,
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
            axios.get(`${this.url}/search/${this.selectedCenter}/${this.selectedYear}/${term}`)
            .then(({data})=>{
                this.data = [];
                data.forEach(item=>this.data.push(item));
            })
            .catch(error=>{
                this.data = [];
                throw error;
            })
            .finally(()=>{this.isFetching = false})
        }, 0),
        selected(option) {
            window.location.href = this.url  + '/' + option.id ;
        }
    }
}
</script>