<template>
    <div>
        <b-table :data="data" :striped=true :hoverable="true">
            <template slot-scope="props">
                <b-table-column field="session_number" label="Número de sesión" sortable="">
                    {{ props.row.session_number }}
                </b-table-column>
                <b-table-column field="created_at" label="Fecha de registro">
                    {{ props.row.created_at }}
                </b-table-column>
                <b-table-column label="Editar">
                    <a href="#">
                        <fai icon="edit" size="2x" />
                    </a>
                </b-table-column>
                <b-table-column label="Ver archivo">
                    <a href="">
                        <fai icon="file-pdf" size="2x" />
                    </a>
                </b-table-column>
                <b-table-column label="Borrar">
                    <a href="#" @click="openModal(props.row.session_number)">
                        <fai icon="trash" size="2x" />
                    </a>
                </b-table-column>
            </template>
        </b-table>
        <b-modal :active.sync="isVisible">
            <div class="card">
                <header class="modal-card-head">
                    <p class="modal-card-title">¿Está seguro que desea borrar el registro?</p>
                </header>
                <section class="modal-card-body">
                    <div class="content">
                        <p>Elminar el registro borrará también el documento</p>
                    </div>
                </section>
                <footer class="modal-card-foot">
                   <button class="button" type="button" @click="isVisible = false">Cancelar</button>
                   <button class="button is-danger" type="button" @click="deleteRecord">Borrar</button>
                </footer>
            </div>
        </b-modal>
    </div>
</template>

<script>
export default {
        props:['baseUrl', 'rss'],
  data() {
      return {
          data: this.rss,
          isVisible: false,
          selected: null,
      }
  },
  methods: {
      openModal(id) {
          this.isVisible = true;
          this.selected = id;
      },
      deleteRecord() {
          const url = this.baseUrl + "/" + this.selected;
          axios.delete(url)
          .then(ans => {
            this.data = this.data.filter(x => {
                return x.session_number != this.selected;
            });
            this.isVisible = false;
          })
          .catch(error => console.log(error));
          // TODO sweet alert
          // TODO quitar tabla cuando no haya records
      }
  }
};

</script>
