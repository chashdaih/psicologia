<template>
    <div>
        <!-- <a @click.prevent="isModalVisible=true" class="button is-info">Elegir programa</a> -->
        <b-modal :active.sync="isModalVisible" v-on:close="$emit('hide-assign')">
            <header class="modal-card-head">
                <p class="modal-card-title">Elegir programa</p>
            </header>
            <section class="modal-card-body" style="height:50vh;">

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
                        <template slot="empty">No hay resultados</template>
                    </b-autocomplete>
                </b-field>

                <b-field label="Filtrar por semestre" horizontal>
                    <b-select v-model="semester" @input="filter">
                        <option v-for="sem in semesters" :key="sem" :value="sem">{{sem}}</option>
                    </b-select>
                </b-field>

                <b-field v-if="etapa == 'admision' || etapa == 'orientacion' || etapa == 'egreso'" label="Asignar a ..." horizontal>
                    <b-select v-model="assign_code">
                        <option value="admision">Admisión</option>
                        <option value="orientacion">Orientación / consejo breve</option>
                        <option value="egreso">Egreso</option>
                    </b-select>
                </b-field>
                <p class="is-italic" v-else>Reasignación</p>

                <b-table v-if="programs.length > 0"
                    :data="programs"
                    :columns="columns"
                    :selected.sync="selected_program"
                    :loading="fetching_programs"
                ></b-table>
                <b-notification :closable="false" v-else>
                    No se encontraron programas con los filtros seleccionados
                    <b-loading :is-full-page="false" :active.sync="fetching_programs" ></b-loading>
                </b-notification>
            </section>
            <footer class="modal-card-foot">
                <button class="button" type="button" @click="closeModal">Cancelar</button>
                <button class="button is-success" @click="asignar" :disabled="selected_program == null" :class="{'is-loading': assigning}" >Asignar a programa seleccionado</button>
            </footer>
        </b-modal>
    </div>
</template>

<script>
import Swal from 'sweetalert2';
export default {
    props:['stages', 'etapa', 'supervisors', 'base_url', 'user_id', 'isVisible', 'semesters'],
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
                {
                    field: 'nombre',
                    label: 'Centro'
                }
            ],
            fetching_programs: false, 
            assigning: false,
            semester: this.semesters[this.semesters.length -1],
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
        closeModal(){
                this.isModalVisible = false;
                this.$emit('hide-assign');
        },
        selected(option) {
            if (!option) {
                return;
            }
            this.selected_supervisor = option.id_supervisor;
            this.filter();
        },
        filter() {
            this.fetching_programs = true;
            // const url = this.base_url + "/filtrar_por_etapa/" + this.selected_stage + "/" + this.selected_supervisor + "/" + this.assign_code;
            const url = `${this.base_url}/filtrar_por_etapa/${this.selected_stage}/${this.selected_supervisor}/${this.assign_code}/${this.semester}`;
            axios.get(url)
            .then(ans=>{
                this.selected_program = null;
                this.programs=ans.data;
            })
            .catch(err=>console.log(err))
            .finally(()=>this.fetching_programs = false);
        },
        asignar() {
            this.assigning = true;
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
            })
            .finally(()=>this.assigning = false);
            
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
