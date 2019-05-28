<template>
    <div>
        <form v-if="stages" action="">
            <b-field label="Filtrar por escenario" horizontal>
                <b-select
                v-model="selected_stage" 
                @input="filter()"
                placeholder="Selecciona un escenario">
                <option value=0>Todos los escenarios</option>
                <option 
                    v-for="stage in stages"
                    :value=stage.id_centro
                    :key=stage.id_centro
                    >@{{ stage.nombre }}</option>
                </b-select>
            </b-field>
        </form>
        <br>
        <form v-if="supervisors" action="">
            <b-field label="Filtrar por supervisor" horizontal>
                <b-autocomplete
                    v-model="name"
                    placeholder="Selecciona un supervisor"
                    :keep-first=true
                    :open-on-focus=true
                    :data="filteredDataObj"
                    field="full_name"
                    @select="option => {selected_supervisor = option.id_supervisor; filter();}">
                    <template slot="header">
                        <a @click="()=> {selected_supervisor=0; filter();}">
                            <span> Todos los supervisores </span>
                        </a> 
                    </template>
                    <template slot="empty">No hay resultados para @{{name}}</template>
                </b-autocomplete>
            </b-field>
        </form>
        <br>
        <form action="">
            <b-field label="Filtrar por periodo" horizontal>
                <b-select 
                v-model="selected_sem" 
                @input="filter()"
                placeholder="Selecciona un periodo">
                    <option value=0>Todos los periodos</option>
                <option 
                    v-for="sem in semestres"
                    :value=sem
                    :key=sem
                    >@{{ sem }}</option>
                </b-select>
            </b-field>
        </form>
        <br>
    </div>
</template>

<script>
export default {
        props:['url', 'stages', 'supervisors', 'stage'],
  data() {
    return {
      selected_stage: this.stage,
      selected_supervisor: this.supervisor,
      semestres: ['2020-1', '2019-2', '2019-1', '2018-2', '2018-1', '2017-2'],
      selected_sem: '2020-1',
      isLoading: false,
      csrf: document.head.querySelector('meta[name="csrf-token"]').content,
      sups: this.supervisors,
      name: ''
    };
  },
  methods: {
    filter() {
        this.isLoading = true;
        axios.get(this.url + "/filter/" + this.selected_stage + "/" + this.selected_supervisor + "/" + this.selected_sem)
        .then(response => {
        this.isLoading = false;
          this.recs = response.data
        }).catch(function(error) {
        this.isLoading = false;
          console.log(error);
          // TODO alert error
        })
    }
  },
  computed: {
      filteredDataObj() {
          return this.supervisors.filter((option) => {
              return option.full_name
                  .toString()
                  .toLowerCase()
                  .indexOf(this.name.toLowerCase()) >= 0
          })
      }
  }
};

</script>
