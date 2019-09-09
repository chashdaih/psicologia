<template>
  <form action="#">
        <b-table :data="pats" >
            <template slot-scope="props">
                <b-table-column field="file_number" label="No. expediente" sortable >
                    {{props.row.file_number}}
                </b-table-column>
                <b-table-column field="curp" label="No. cuenta / No. trabajador / CURP" sortable >
                    {{props.row.curp}}
                </b-table-column>
                <b-table-column field="programs" label="Programas" sortable >
                    <ul>
                        <li v-for="(program, index) in props.row.programs" :key="index">{{program}}</li>
                    </ul>
                </b-table-column>
                <b-table-column field="centers" label="Centros" sortable >
                    <ul>
                        <li v-for="(center, index) in props.row.centers" :key="index">{{center}}</li>
                    </ul>
                </b-table-column>
                <b-table-column field="supervisors" label="Supervisores" sortable >
                    <ul>
                        <li v-for="(supervisor, index) in props.row.supervisors" :key="index">{{supervisor}}</li>
                    </ul>
                </b-table-column>
                <b-table-column label="Ir a procesos" >
                    <a :href="baseUrl + '/' + props.row.id">
                        <fai icon="arrow-circle-right" size="2x" />
                    </a>
                </b-table-column>
                <b-table-column v-if="type>4" label="Borrar">
                    <a @click.prevent="show(props.row)" class="button is-danger">
                        <span class="icon"><fai icon="trash" size="2x" /></span>
                    </a>
                </b-table-column>
            </template>
        </b-table>
        <div class="modal" :class="{ 'is-active': modalVisible }">
            <div class="modal-background close-modal" @click="hide"></div>
                <div class="modal-card">
                    <header class="modal-card-head">
                    <p class="modal-card-title">Borrar persona atendida<span id="span-id-cita"></span></p>
                    <button class="delete close-modal" aria-label="close" @click="hide"></button>
                </header>
                <section class="modal-card-body">
                    <div class="content">
                        <p>¿Está seguro que quiere eliminar al paciente con número de expediente <span class="has-text-weight-bold">{{fileNumber}}</span>?</p>
                    </div>
                </section>
                <footer class="modal-card-foot">
                    <button class="button is-danger" :class="{'is-loading': isWaiting}" @click.prevent="deletePatient">Borrar</button>
                    <button class="button close-modal" @click.prevent="hide">Cerrar</button>
                </footer>
            </div>
        </div>
  </form>
</template>

<script>
import Swal from 'sweetalert2';
export default {
    props: ['baseUrl', 'patients', 'type'],
    data() {
        return {
            pats: this.patients,
            modalVisible: false,
            patientId: 0,
            fileNumber: '',
            isWaiting: false
        }
    },
    methods: {
        show(pat) {
            this.patientId = pat.id;
            this.fileNumber = pat.file_number;
            this.modalVisible=true;
        },
        hide() {
            this.patientId = 0;
            this.fileNumber = '';
            this.modalVisible = false;
        },
        deletePatient() {
            this.isWaiting=true;
            axios.delete(this.baseUrl + '/' + this.patientId)
            .then(ans=>{
                 Swal.fire({
                    title: "Éxito",
                    type: "success",
                    text: "La persona atendida fue eliminada.",
                    confirmButtonText: "Aceptar",
                    onClose: ()=> {
                        this.pats = this.pats.filter(pat=>{
                            return pat.id != this.patientId;
                        });
                        this.hide();
                    }
                });
            })
            .catch(err=>{
                console.log(err);
                Swal.fire({
                    title: "Ocurrió un error",
                    text: err,
                    type: "error",
                    confirmButtonText: "Aceptar"
                });
            })
            .finally(()=>this.isWaiting=false)
        }
    }
}
</script>