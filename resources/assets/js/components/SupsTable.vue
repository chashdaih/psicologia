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
                  style="width:0px;"
                    v-for="stage in stages"
                    :value=stage.id_centro
                    :key=stage.id_centro
                    >{{ stage.nombre }}</option>
                </b-select>
            </b-field>
        </form>
        <br>
        <form v-if="supervisors" action="">
            <b-field label="Buscar por nombre" horizontal>
                <b-autocomplete
                    v-model="name"
                    placeholder="Selecciona un supervisor"
                    :keep-first=true
                    :open-on-focus=true
                    :data="filteredDataObj"
                    field="full_name"
                    @select="selected">
                    <template slot="header">
                        <a @click="()=> {selected_supervisor=0; filter();}">
                            <span> Todos los supervisores </span>
                        </a> 
                    </template>
                    <template slot="empty">No hay resultados para {{name}}</template>
                </b-autocomplete>
            </b-field>
        </form>
        <br>
        <br>

    <b-table
      :data="sups"
      :loading="isLoading"
      >
    <template slot-scope="props">
        <b-table-column
          field="full_name"
          label="Supervisor"
          sortable
        >{{ props.row.full_name }}</b-table-column>

        <b-table-column
          field="centro" 
          label="Centro" 
          sortable>{{ props.row.centro }}</b-table-column>

        <b-table-column
          field="estatus" 
          label="Estatus"
          sortable>{{ props.row.estatus }}</b-table-column>

        <b-table-column label="Editar" centered>
          <a :href='url + "/supervisor/" + props.row.id_supervisor + "/edit"'>
              <fai icon="file-code" size="2x" />
          </a>
        </b-table-column>

        <b-table-column label="Eliminar" centered>
          <form :action='url + "/supervisor/" + props.row.id_supervisor' method="POST">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="_token" :value="csrf" />
            <button type="submit" class="button is-danger is-outlined">
              <fai icon="trash" size="2x" />
            </button>
          </form>
        </b-table-column>
    </template>
    </b-table>
    </div>
</template>

<script>
export default {
        props:['url', 'stages', 'supervisors'],
  data() {
    return {
        sups: this.supervisors,
        selected_stage: 0,
        selected_supervisor: 0,
        isLoading: false,
        csrf: document.head.querySelector('meta[name="csrf-token"]').content,
        name: ''
    };
  },
  methods: {
    filter() {
        // this.isLoading = true;
        // axios.get(this.url + "/supervisor/filter/" + this.selected_stage)
        // .then(response => {
        // this.isLoading = false;
        //   this.sups = response.data
        // }).catch((error) => {
        // this.isLoading = false;
        //   console.log(error);
        //   // TODO alert error
        // });
        this.sups = this.supervisors.filter(sup => sup.id_centro == this.selected_stage);
    },
    selected(option) {
      window.location.href = this.url + '/supervisor/' + option.id_supervisor + '/edit';
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
