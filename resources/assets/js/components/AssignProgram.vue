<template>
    <div>
        <!-- <a @click.prevent="isModalVisible=true" class="button is-info">Elegir programa</a> -->
        <b-modal :active.sync="isModalVisible">
            <header class="modal-card-head">
                <p class="modal-card-title">Elegir programa</p>
            </header>
            <section class="modal-card-body" style="height:50vh;">
                <b-field label="Escoge un escenario" horizontal>
                    <b-select
                        v-model="selected_stage" 
                        @input="filter_sups()"
                        placeholder="Selecciona un escenario">
                        <option value=0>Todos los escenarios</option>
                        <option style="width:50px;"
                        v-for="stage in stages"
                        :value=stage.id_centro
                        :key=stage.id_centro
                        >{{ stage.nombre }}</option>
                    </b-select>
                </b-field>

                <b-field label="Filtrar por supervisor" horizontal>
                    <b-autocomplete
                        v-model="name"
                        placeholder="Selecciona un supervisor"
                        :keep-first=false
                        :open-on-focus=true
                        :data="filteredDataObj"
                        field="full_name"
                        @select="selected"
                        @focus="name = ''"
                        ref="autocomplete"
                        >
                        <template slot="header">
                            <a @click="allSups()">
                                <span> Todos los supervisores </span>
                            </a> 
                        </template>
                        <template slot="empty">No hay resultados</template>
                    </b-autocomplete>
                </b-field>

                <b-field v-if="etapa == 'admision' || etapa == 'orientacion' || etapa == 'egreso'" label="Asignar a ..." horizontal>
                    <b-select v-model="assign_code">
                        <option value="admision">Admisión</option>
                        <option value="orientacion">Orientación / consejo breve</option>
                        <option value="egreso">Egreso</option>
                    </b-select>
                </b-field>
                <p class="is-italic" v-else>Reasignación</p>

                <b-table
                    :data="programs"
                    :columns="columns"
                    :selected.sync="selected_program"
                ></b-table>
            </section>
            <footer class="modal-card-foot">
                <button class="button" type="button" @click="isModalVisible = false">Cancelar</button>
                <button class="button is-success" @click="asignar">Seleccionar programa</button>
            </footer>
        </b-modal>
    </div>
</template>

<script>
import Swal from 'sweetalert2';
export default {
    props:['stages', 'etapa', 'supervisors', 'base_url', 'user_id', 'isVisible'],
    data() {
        return {
            programs: [],
            isModalVisible: false,
            selected_stage: 0,
            selected_supervisor: 0,
            selected_program: null,
            sups: this.supervisors,
            name: '',
            assign_code: this.etapa,
            columns: [
                {
                    field: 'programa',
                    label: 'Nombre del programa',
                },
            ]
        }
    },
    watch: {
        isVisible() {
            if (this.isVisible) {
                this.isModalVisible  = true;
            } else {
                this.isModalVisible = false;
            }
        }
    },
    methods: {
        selected(option) {
            if (!option) {
                return;
            }
            if (option=="Todos los supervisores") {
                this.selected_supervisor = 0;
            } else {
                this.selected_supervisor = option.id_supervisor;
            }
            this.filter();
        },
        allSups() {
            this.selected_supervisor=0;
            this.filter();
            this.$refs.autocomplete.setSelected("Todos los supervisores");
        },
        filter_sups(){
            // console.log(this.selected_stage);
            if(this.selected_stage == 0) {
                this.sups = this.supervisors;
                return;
            }
            this.sups = this.supervisors.filter(option => option.id_centro == this.selected_stage);
            return;
        },
        filter() {
            const url = this.base_url + "/filtrar_por_etapa/" + this.selected_stage + "/" + this.selected_supervisor + "/" + this.assign_code;
            axios.get(url)
            .then(ans=>this.programs=ans.data)
            .catch(err=>console.log(err));
        },
        asignar() {
            const url = this.base_url + "/asignar_por_etapa";
            const params = {
                patient_id: this.user_id,
                program_id: this.selected_program.id_practica,
                etapa: this.assign_code
            };
            axios.post(url, params)
            .then(
                Swal.fire({
                    title: "Éxito",
                    type: "success",
                    text: "El programa se asignó correctamente",
                    confirmButtonText: "Aceptar",
                    onClose: () => this.$emit('patient-assigned', this.user_id)
                })
            )
            .catch(err=>{
                Swal.fire({
                    title: "Ocurrió un error",
                    text: err,
                    type: "error",
                    confirmButtonText: "Aceptar"
                });
            });
            
        }
    },
  computed: {
      filteredDataObj() {
          return this.sups.filter((option) => {
              return option.full_name
                  .toString()
                  .toLowerCase()
                  .indexOf(this.name.toLowerCase()) >= 0
          })
      }
  }
}
</script>
