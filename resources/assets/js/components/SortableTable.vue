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
              >{{ stage.nombre }}</option>
          </b-select>
        </b-field>
    </form>
    <br>
    <form v-if="supervisors" action="">
        <b-field label="Filtrar por supervisor" horizontal>
            <b-autocomplete
                v-model="name"
                placeholder="Selecciona un supervisor"
                :keep-first=false
                :open-on-focus=true
                :data="filteredDataObj"
                field="full_name"
                @select="option => {selected_supervisor = option.id_supervisor; filter();}"
                @focus="clearName"
                ref="autocomplete"
                >
                <template slot="header">
                    <a @click="allSups()">
                        <span> Todos los supervisores </span>
                    </a> 
                </template>
                <template slot="empty">No hay resultados para {{name}}</template>
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
              >{{ sem }}</option>
          </b-select>
        </b-field>
    </form>
    <br>
    <div v-if="supervisors" class="has-text-centered">
      <a class="button is-success" :href='url + "/excel/" + selected_stage + "/" + selected_supervisor + "/" + selected_sem'>Descargar excel</a>
    </div>
    <br>
    <b-table  v-if="recs.length > 0"
      :data="recs"
      :loading="isLoading"
      :paginated="false"
      :per-page="5"
      >
      <template slot-scope="props">
        <b-table-column field="programa" 
          label="Nombre del programa" 
          sortable>{{ props.row.programa }}</b-table-column>

        <b-table-column v-if="supervisors"
          field="full_name"
          label="Supervisor"
          sortable
        >{{ props.row.full_name }}</b-table-column>

        <b-table-column field="semestre_activo" 
          label="Periodo" 
          sortable>{{ props.row.semestre_activo }}</b-table-column>

        <b-table-column v-if="stages"
          field="centro" 
          label="Centro" 
          sortable>{{ props.row.centro }}</b-table-column>

        <b-table-column
          field="tipo" 
          label="Curricular / Extra" 
          sortable>{{ props.row.tipo }}</b-table-column>

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

        <b-table-column label="Eliminar" centered>
          <form :action='url + "/" + props.row.id_practica' method="POST" :ref=props.row.id_practica>
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="_token" :value="csrf" />
            <button @click.prevent="confirmDelete(props.row.id_practica)" class="button is-danger is-outlined">
              <fai icon="trash" size="2x" />
            </button>
          </form>
        </b-table-column>
      </template>
    </b-table>

    <p v-else>No hay registros con los filtros especificados</p>
    <div class="modal" v-bind:class="{'is-active': isActive}">
      <div class="modal-background" @click="closeModal"></div>
      <div class="modal-card">
        <header class="modal-card-head">
          <p class="modal-card-title">¡Atención!</p>
          <button class="delete" aria-label="close" @click="closeModal"></button>
        </header>
        <section class="modal-card-body">
          <p class="has-text-weight-semibold">¿Está seguro que desea borrar el programa?</p>
          <p class="is-italic">Borrar el programa dará de baja a todos los estudiantes inscritos y se eliminarán sus documentos.</p>
        </section>
        <footer class="modal-card-foot">
          <button class="button is-danger" @click="deleteRow()">Borrar programa</button>
          <button class="button" @click="closeModal">Cancelar</button>
        </footer>
      </div>
    </div>
  </div>
</template>

<script>
export default {
    props:['records', 'url', 'stages', 'supervisors', 'stage', 'supervisor'],
  data() {
    return {
      recs: this.records,
      selected_stage: this.stage,
      selected_supervisor: this.supervisor,
      semestres: ['2020-1', '2019-2', '2019-1', '2018-2', '2018-1', '2017-2'],
      selected_sem: '2020-1',
      isLoading: false,
      csrf: document.head.querySelector('meta[name="csrf-token"]').content,
      sups: this.supervisors,
      name: '',
      isActive: false,
      rowId: null
    };
  },
  mounted() {
    this.$refs.autocomplete.setSelected("Todos los supervisores");
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
    },
    confirmDelete(id) {
      this.rowId = id;
      this.isActive =  true;
    },
    deleteRow() {
      // TODO ajax 
      this.$refs[this.rowId].submit();
    },
    closeModal() {
      this.isActive = false;
    },
    allSups() {
      this.selected_supervisor=0;
      this.filter();
      this.$refs.autocomplete.setSelected("Todos los supervisores");
    },
    clearName() {
      this.name = '';
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