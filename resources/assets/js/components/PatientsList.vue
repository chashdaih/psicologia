<template>
    <div>
        <div class="field">
            <label class="label">Ver pacientes en otra etapa del proceso</label>
            <div class="control">
                <div class="select">
                    <select v-model="progress">
                        <option v-for="(title, idx) in titles" 
                            :value="idx" :key="idx"
                        >{{title}}</option>
                    </select>
                </div>
            </div>
        </div>
        <h1 class="title">{{titles[progress]}}</h1>
        <div v-if="progress==2">
            <b-field v-if="userType > 3" label="Elige un supervisor">
                <b-autocomplete v-model="supName"
                    :data="filteredSups"
                    field="full_name"
                    @select="supSelected"
                    @focus="supName = ''"
                    placeholder="Selecciona un supervisor"
                    ref="autocomplete"
                    :open-on-focus=true
                >
                    <template slot="empty">No hay resultados para {{supName}}</template>
                </b-autocomplete>
            </b-field>
            <div class="field">
                <label class="label">Selecciona un programa</label>
                <div class="select" :class="{'is-loading': loadingPrograms}">
                    <select v-model="selectedProgram">
                        <option value="0" disabled>Elige un programa</option>
                        <option v-for="(program, idx) in programs" :value="program.id_practica" :key="idx">{{program.programa}}</option>
                    </select>
                </div>
            </div>
            <table v-if="assignedPatients.length > 0 || loadingPatients" class="table is-fullwidth is-hoverable is-striped">
                <thead>
                    <tr>
                        <th>Número de expediente</th>
                        <th>Nombre de la persona atendida</th>
                        <th>Ir a procesos</th>
                        <th v-if="userType > 4">Borrar</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(patient, idx) in assignedPatients" :key="idx">
                        <td>{{patient.file_number}}</td>
                        <td>{{patient.name + " " + patient.last_name + " " + patient.mothers_name}}</td>
                        <td>
                            <a :href="baseUrl + '/usuario/' + patient.id">
                                <fai icon="arrow-circle-right" size="2x" />
                            </a>
                        </td>
                        <td v-if="userType > 4">
                            <a @click.prevent="show(patient)" class="button is-danger">
                                <span class="icon"><fai icon="trash" size="2x" /></span>
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
            <p v-else>No hay pacientes con los filtros seleccionados</p>
        </div>

        <div v-if="progress==1">
            <div class="field">
                <label class="label">Ver personas atendidas registradas en el centro:</label>
                <div class="control">
                    <div class="select" :class="{'is-loading':loadingCenters}">
                        <select v-model="selectedCenter">
                            <option value="0" disabled>Elige un centro</option>
                            <option v-for="(center, idx) in centers" 
                                :value="center.id_centro" :key="idx"
                            >{{center.nombre}}</option>
                        </select>
                    </div>
                </div>
            </div>
            <table v-if="programNeeded.length > 0" class="table is-fullwidth is-hoverable is-striped">
                <thead>
                    <tr>
                        <th>No. expediente</th>
                        <th>No. cuenta / No. trabajador / CURP</th>
                        <th>Nombre de la persona atendida</th>
                        <th>Registrado por</th>
                        <th colspan="2" style="text-align: center">FDG</th>
                        <th colspan="2" style="text-align: center">CDR</th>
                        <th v-if="userType > 4">Asignar a programa</th>
                        <th v-if="userType > 4">Borrar</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(pat, idx) in programNeeded" :key="idx">
                        <td>{{pat.file_number}}</td>
                        <td>{{pat.curp}}</td>
                        <td>{{pat.name + " " + pat.last_name + " "+ pat.mothers_name}}</td>
                        <td>{{pat.other_filler}}</td>
                        <td class="has-text-centered" >
                            <a :href="baseUrl + '/usuario/' + pat.id + '/fdg/' + pat.fdg_id + '/edit'">
                                <fai icon="edit" size="2x" />
                            </a>
                        </td>
                        <td class="has-text-centered" >
                            <a :href="baseUrl + '/usuario/' + pat.id + '/fdg/' + pat.fdg_id">
                                <fai icon="file-pdf" size="2x" />
                            </a>
                        </td>
                        <td class="has-text-centered" >
                            <a :href="baseUrl + '/usuario/' + pat.id + '/cdr/' + pat.cdr_id + '/edit'">
                                <fai icon="edit" size="2x" />
                            </a>
                        </td>
                        <td class="has-text-centered" >
                            <a :href="baseUrl + '/usuario/' + pat.id + '/cdr/' + pat.cdr_id">
                                <fai icon="file-pdf" size="2x" />
                            </a>
                        </td>
                        <td v-if="userType > 4">
                            <a @click.prevent="showChooser(pat)" class="button is-info">Elegir programa</a>
                        </td>
                        <td v-if="userType > 4">
                            <a @click.prevent="show(pat)" class="button is-danger">
                                <span class="icon"><fai icon="trash" size="2x" /></span>
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
            <p v-else>No se encontraron personas atendidas con los filtros seleccionados</p>

            <assign-program
                :stages="centers"
                :supervisors="supervisors"
                etapa="admision"
                :base_url="baseUrl"
                :user_id="selectedPatient"
                :isVisible="isVisibleChooser"
                v-on:patient-assigned="removeAssigned"
            ></assign-program>

        </div>

        <div v-if="progress==0">
            <div class="field">
                <label class="label">Selecciona un centro</label>
                <div class="control">
                    <div class="select" :class="{'is-loading':loadingCenters}">
                        <select v-model="selectedCenter">
                            <option value="0">Elige un centro</option>
                            <option v-for="(center, idx) in centers" 
                                :value="center.id_centro" :key="idx"
                            >{{center.nombre}}</option>
                        </select>
                    </div>
                </div>
            </div>
            <table v-if="cdrNeeded.length > 0" class="table is-fullwidth is-hoverable is-striped">
                <thead>
                    <tr>
                        <th>No. expediente</th>
                        <th>No. cuenta / No. trabajador / CURP</th>
                        <th>Nombre de la persona atendida</th>
                        <th>Registrado por</th>
                        <th>Editar ficha de datos generales</th>
                        <th>Descargar ficha de datos generales</th>
                        <th>Realizar CDR</th>
                        <th v-if="userType > 4">Borrar</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(pat, idx) in cdrNeeded" :key="idx">
                        <td>{{pat.file_number}}</td>
                        <td>{{pat.curp}}</td>
                        <td>{{pat.name + " " + pat.last_name + " "+ pat.mothers_name}}</td>
                        <td>{{pat.other_filler}}</td>
                        <td class="has-text-centered" >
                            <a :href="baseUrl + '/usuario/' + pat.id + '/fdg/' + pat.fdg + '/edit'">
                                <fai icon="edit" size="2x" />
                            </a>
                        </td>
                        <td class="has-text-centered" >
                            <a :href="baseUrl + '/usuario/' + pat.id + '/fdg/' + pat.fdg">
                                <fai icon="file-pdf" size="2x" />
                            </a>
                        </td>
                        <td class="has-text-centered" >
                            <a :href="baseUrl + '/usuario/' + pat.id + '/cdr/create'">
                                <fai icon="plus-circle" size="2x" />
                            </a>
                        </td>
                        <td v-if="userType > 4">
                            <a @click.prevent="show(pat)" class="button is-danger">
                                <span class="icon"><fai icon="trash" size="2x" /></span>
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
            <p v-else>No se encontraron personas atendidas con los filtros seleccionados</p>
        </div>
        
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
    </div>
</template>

<script>
import Swal from 'sweetalert2';
import AssignProgram from './AssignProgram';
export default {
    components: { AssignProgram },
    props:['supervisors', 'initialSup', 'userType', 'baseUrl', 'prgms'],
    data() {
        return {
            titles: [
                'Personas que necesitan finalizar su primer contacto',
                'Personas atendidas sin programa asignado',
                'Personas atendidas asignadas a programas',
            ],
            progress: 2, // 0 - porCdr, 1 - porAsignar, 2 - asignados
            progressTitle: 'Personas atendidas asignadas a programas',
            // assigned
            selectedSup: this.initialSup,
            supName: '',
            programs: [],
            assignedPatients: [],
            selectedProgram: 0,
            loadingPrograms: false,
            loadingPatients: false,
            // cdr
            loadingCenters: false,
            centers: [],
            selectedCenter: 0,
            loadingCdr: false,
            cdrNeeded: [],
            // no program assigned
            loadingNoProg: false,
            programNeeded: [],
            selectedPatient: 0,
            isVisibleChooser: false,
            // delete
            modalVisible: false,
            patientId: 0,
            fileNumber: '',
            isWaiting: false,
        }
    },
    methods: {
        // asigned
        supSelected(option) {
            if (!option) {
                return;
            }
            this.selectedSup = option.id_supervisor;
        },
        getPrograms() {
            this.loadingPrograms = true;
            this.patients = [];
            const url = this.baseUrl + '/get-programs/' + this.selectedSup;
            axios.get(url)
            .then(res=>{this.programs = res.data})
            .catch(err=>console.log(err))
            .finally(()=> {
                this.loadingPrograms = false;
            })
        },
        getPatients() {
            this.loadingPatients = true;
            const url = this.baseUrl + '/get-patients/' + this.selectedProgram;
            axios.get(url)
            .then(res=>this.assignedPatients= res.data)
            .catch(err=>console.log(err))
            .finally(()=>this.loadingPatients=false);
        },
        // cdr needed
        getCenters() {
            this.loadingCenters = true;
            const url = this.baseUrl + '/centers';
            axios.get(url)
            .then(res=>this.centers=res.data)
            .catch(err=>console.log(err))
            .finally(()=>this.loadingCenters=false)
        },
        getCdr() {
            this.loadingCdr = true;
            const url = this.baseUrl + '/cdrneeded/' + this.selectedCenter;
            axios.get(url)
            .then(res=>this.cdrNeeded=res.data)
            .catch(err=>console.log(err))
            .finally(()=>this.loadingCdr=false)
        },
        // unassigned
        getUnassigned() {
            const url = this.baseUrl + '/programneeded/' + this.selectedCenter;
            axios.get(url)
            .then(res=>this.programNeeded=res.data)
            .catch(err=>console.log(err))
            // .finally(()=>this.loadingCdr=false)
        },
        showChooser(pat) {
            this.selectedPatient = pat.id;
            this.isVisibleChooser = true;
        },
        removeAssigned(id) {
            this.programNeeded = this.programNeeded.filter(x=>{
                return x.id != id;
            })
            this.isVisibleChooser = false;
            this.resetAssignedData();
        },
        resetAssignedData() {
            // TODO resetear por que la info puede que sea obsoleta
        },
        //delete
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
            axios.delete(this.baseUrl + '/usuario/' + this.patientId)
            .then(ans=>{
                 Swal.fire({
                    title: "Éxito",
                    type: "success",
                    text: "La persona atendida fue eliminada.",
                    confirmButtonText: "Aceptar",
                    onClose: ()=> {
                        if (this.progress == 2) {
                            this.assignedPatients = this.assignedPatients.filter(pat=>{
                                return pat.id != this.patientId;
                            });
                        } else if (this.progress == 1) {
                            this.programNeeded = this.programNeeded.filter(pat=>{
                                return pat.id != this.patientId;
                            });
                        } else {
                            this.cdrNeeded = this.cdrNeeded.filter(pat=>{
                                return pat.id != this.patientId;
                            });
                        }
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
    },
    watch: {
        selectedSup: function() {this.getPrograms()},
        selectedProgram: function () {
            this.getPatients();
        },
        progress: function() {
            if (this.progress == 0 || this.progress == 1) {
                if (this.centers.length < 1) {
                    this.getCenters();
                }
            }
        },
        selectedCenter: function() {
            if (this.progress == 0) {
                this.getCdr()
            } else if (this.progress == 1) {
                this.getUnassigned()
            }
        }
    },
    created() {
        const sup = this.supervisors.find(s=>{
            return s.id_supervisor == this.initialSup;
        })
        if (sup) {
            this.supName = sup.full_name;
        }

        if (this.userType == 3) {
            this.programs = this.prgms;
        } else {
            this.getPrograms();
        }

    },
    computed: {
        filteredSups() {
            return this.supervisors.filter(option => {
                return option.full_name
                        .toString()
                        .toLowerCase()
                        .indexOf(this.supName.toLowerCase()) >= 0
            })
        }
    }
}
</script>