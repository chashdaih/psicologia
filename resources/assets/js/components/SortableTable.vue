<template>
  <div id="app" class="container">
    <section>
        <form action="">
            <b-field label="Filtrar por escenario" horizontal>
              <b-select 
                v-model="selected_stage" 
                @input="filterByStage()"
                placeholder="Selecciona un escenario">
                <option value=0>Todos los escenarios</option>
                <option 
                  v-for="(stage, index) in stages"
                  :value="stage.escenario"
                  :key="index"
                  >{{ stage.escenario }}</option>
              </b-select>
            </b-field>
        </form>
      <b-table :data="data">
        <template slot-scope="props">
          <b-table-column field="programa" 
            label="Nombre del programa" 
            sortable>{{ props.row.programa }}</b-table-column>
          <b-table-column field="semestre_activo" 
            label="Periodo" 
            sortable>{{ props.row.semestre_activo }}</b-table-column>
          <b-table-column label="Descargar pdf" centered>
            <a :href='url + "/" + props.row.id_practica'>
                <fai icon="file-pdf" size="2x" />
            </a>
          </b-table-column>
          <b-table-column label="Duplicar programa" centered>
            <a :href='url + "/pdf/" + props.row.id_practica'>
                <fai icon="clone" size="2x" />
            </a>
          </b-table-column>
        </template>
      </b-table>
    </section>
  </div>
</template>

<script>
export default {
    props:['ldata', 'url', 'stages'],
  data() {
    return {
      data: this.ldata,
      isPaginated: true,
      isPaginationSimple: false,
      defaultSortDirection: "asc",
      currentPage: 1,
      perPage: 5,
      selected_stage: null
    };
  },
  methods: {
    filterByStage() {
      // if (this.selected_stage != "") {
        axios.get(this.url + "/filter/" + this.selected_stage)
        .then(response => {
          this.data = response.data
        }).catch(function(error) {
          console.log(error);
        })
      }
      
    // }
  }
};
</script>