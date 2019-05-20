<template>
  <div>
    <form action="">
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
              >{{ stage.nombre }}</option>
          </b-select>
        </b-field>
    </form>
    <br>
    <form action="">
        <b-field label="Filtrar por supervisor" horizontal>
          <b-select 
            v-model="selected_supervisor" 
            @input="filter()"
            placeholder="Selecciona un supervisor">
            <option value=0>Todos los supervisores</option>
            <option 
              v-for="supervisor in supervisors"
              :value=supervisor.id_supervisor
              :key=supervisor.id_supervisor
              >{{ supervisor.full_name }}</option>
          </b-select>
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
              >{{ sem }}</option>
          </b-select>
        </b-field>
    </form>
    <br>
    <b-table  v-if="data.length > 0"
      :data="data"
      :loading="isLoading"
      :paginated="true"
      :per-page="5">
      <template slot-scope="props">
        <b-table-column field="programa" 
          label="Nombre del programa" 
          sortable>{{ props.row.programa }}</b-table-column>

        <b-table-column field="full_name"
          label="Supervisor"
          sortable
        >{{ props.row.full_name }}</b-table-column>

        <b-table-column field="semestre_activo" 
          label="Periodo" 
          sortable>{{ props.row.semestre_activo }}</b-table-column>

        <b-table-column field="centro" 
          label="Centro" 
          sortable>{{ props.row.centro }}</b-table-column>

        <b-table-column label="Editar" centered>
          <a :href='url + "/" + props.row.id_practica + "/edit"'>
              <fai icon="file-code" size="2x" />
          </a>
        </b-table-column>

        <b-table-column label="Descargar pdf" centered>
          <a :href='url + "/pdf/" + props.row.id_practica'>
              <fai icon="file-pdf" size="2x" />
          </a>
        </b-table-column>
      </template>
    </b-table>
    <p v-else>No hay registros con los filtros especificados</p>
  </div>
</template>

<script>
export default {
    props:['ldata', 'url', 'stages', 'supervisors'],
  data() {
    return {
      data: this.ldata,
      selected_stage: 0,
      selected_supervisor: 0,
      semestres: ['2020-1', '2019-2', '2019-1', '2018-2', '2018-1', '2017-2'],
      selected_sem: '2020-1',
      isLoading: false
    };
  },
  methods: {
    filter() {
        this.isLoading = true;
        axios.get(this.url + "/filter/" + this.selected_stage + "/" + this.selected_supervisor + "/" + this.selected_sem)
        .then(response => {
        this.isLoading = false;
          this.data = response.data
        }).catch(function(error) {
        this.isLoading = false;
          // console.log(error);
          // TODO alert error
        })

    }
  }
};
</script>