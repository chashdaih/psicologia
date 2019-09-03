<template>
    <div class="modal" :class="{ 'is-active': isActive }">
        <div class="modal-background" @click="hide"></div>
        <div class="modal-card">
            <header class="modal-card-head">
                <p class="modal-card-title">Agendar nueva cita</p>
                <button class="delete" aria-label="close" @click="hide"></button>
            </header>
            <section class="modal-card-body">
                <h1 class="title is-5" id="modal-centro-name"></h1>
            <h1 class="subtitle">{{ data.room }}, {{fecha}} a las {{ data.time }}</h1>

            <!-- FORM -->
            <form @submit.prevent method="POST">
                <div class="field is-horizontal">
                    <div class="field-label is-normal">
                        <label class="label">Supervisor</label>
                    </div>
                    <div class="field-body">
                        <div class="field">
                            <div class="control">
                                <div class="select" id="supervisor">
                                    <select name="supervisor" @change="supSelected" v-model="selectedSup">
                                        <option value=0 disabled>Selecciona un supervisor</option>
                                        <option v-for="sup in supervisors" :value="sup.id_supervisor" :key="sup.id_supervisor">{{ sup.full_name }}</option>
                                    </select>
                                </div>
                            </div>
                            <p v-if="supError" class="help is-danger" >Este campo es obligatorio</p>
                        </div>
                    </div>
                </div>
                <fieldset id="fieldset-alumno" :disabled="students == null">
                <div class="field is-horizontal">
                    <div class="field-label">
                        <label class="label">Alumno en formación</label>
                    </div>
                    <div class="field-body">
                        <div class="field">
                            <div class="control">
                                <div class="select" id="terapeuta">
                                    <select name="terapeuta" v-model="selectedStudent" @change="studentSelected">
                                        <option value=0 disabled>Selecciona un alumno</option>
                                        <option v-for="student in students" :value="student.num_cuenta" :key="student.num_cuenta">{{ fixName(student) }}</option>
                                        <option value = 9999>El Supervisor brinda la atención</option>
                                    </select>
                                </div>
                            </div>
                            <p v-if="studentError" class="help is-danger">Este campo es obligatorio</p>
                        </div>
                    </div>
                </div>
                </fieldset>
                <div class="field is-horizontal">
                    <div class="field-label is-normal">
                        <label class="label">Servicio</label>
                    </div>
                    <div class="field-body">
                        <div class="control">
                            <div class="select">
                                <select name="servicio" v-model="selectedService">
                                    <option value=0 disabled>Selecciona servicio</option>
                                    <option value="1° Contacto" selected>Primer contacto</option>
                                    <option value="Admision">Admisión (Entrevista inicial)</option>
                                    <option value="Evaluacion">Evaluacion</option>
                                    <option value="Consejo Breve">Consejo Breve</option>
                                    <option value="Intervencion">Intervención</option>
                                    <option value="Seguimiento">Seguimiento</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="field is-horizontal" id="div-uso">
                    <div class="field-label is-normal">
                        <label class="label">Uso del espacio</label>
                    </div>
                    <div class="field-body">
                        <div class="control">
                            <div class="select">
                                <select name="uso" v-model="selectedUse">
                                    <option value=0 disabled>Selecciona uso</option>
                                    <option value="1" selected>Taller/Sesión Grupal</option>
                                    <option value="2">Observación en cámara</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="field is-horizontal">
                    <div class="field-label is-normal">
                        <label class="label">Tipo de público</label>
                    </div>
                    <div class="field-body">
                        <div class="control">
                            <div class="select">
                                <select name="publico" v-model="selectedPublic">
                                    <option value=0 disabled>Selecciona público</option>
                                    <option value="1" selected>Niño</option>
                                    <option value="2">Adolescente</option>
                                    <option value="3">Adulto</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="field is-horizontal">
                    <div class="field-label is-normal">
                        <label class="label">Observaciones</label>
                    </div>
                    <div class="field-body">
                        <div class="control">
                            <textarea name="observaciones" class="textarea" placeholder="Observaciones" v-model="obs"></textarea>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="centro" />
                <input type="hidden" name="hora" />
                <input type="hidden" name="sala" />
                <input type="hidden" name="fecha" />
                <input type="hidden" name="tipo" />
            </form>
            </section>
            <footer class="modal-card-foot">
                <button class="button is-success" @click="makeAppo">Agendar cita</button>
                <button class="button" @click="hide">Cancelar</button>
            </footer>
        </div>
    </div>
</template>

<script>
import { eventBus } from '../app.js';
import Swal from 'sweetalert2';

function titleCase(str) {
  return str.split(' ').map(item => 
         item.charAt(0).toUpperCase() + item.slice(1).toLowerCase()).join(' ');
}

export default {
    props:['supervisors', 'url', 'fecha', 'sendUrl', 'center_id'],
    data() {
        return {
            isActive: false,
            data: {time:null, room:null},
            selectedSup: 0,
            selectedStudent: 0,
            selectedService: "1° Contacto",
            selectedUse: "1",
            selectedPublic: "1",
            obs: "",
            students: null,
            supError: false,
            studentError: false
        }
    },
    created() {
        eventBus.$on('detail-modal', data => {
            this.isActive = true;
            this.data = data;
            console.log(data);
        });
    },
    methods: {
        hide() {
            this.isActive = false;
        },
        supSelected() {
            if (this.selectedSup != 0) {
                this.supError = false;
            }
            axios.get(this.url + this.selectedSup)
            .then(response=> {
                this.students = response.data;
            })
            .catch(error=>console.log(error));
        },
        studentSelected() {
            if (this.selectedStudent != 0) {
                this.studentError = false;
            }
        },
        makeAppo() {
            if (this.selectedSup == 0) {
                this.supError = true;
            }
            if (this.selectedStudent == 0) {
                this.studentError = true;
                return;
            }
            // console.log("seeend");
            // this.$refs.form.submit();
            axios.post(this.sendUrl, {
                id_supervisor: this.selectedSup,
                id_terapeuta: this.selectedStudent,
                servicio: this.selectedService,
                uso_espacio: this.selectedUse,
                tipo_publico: this.selectedPublic,
                observaciones: this.obs!= ""?this.obs:"na",
                tipo_espacio: this.data.room.includes("mara") ? 2 : 1,
                asistencia: 0,
                id_paciente: 0,
                id_centro: this.center_id, // TODO use user center
                fecha: this.fecha,
                hora: this.data.time,
                sala: this.data.room,
                id_especialidad: 1
            })
            .then(()=>{
                Swal.fire({
                    title: "Éxito",
                    type: "success",
                    text: "La cita se registró exitosamente",
                    confirmButtonText: "Aceptar",
                    onClose: function() {
                        location.reload();
                    }
                });
            })
            .catch(error=>{
                Swal.fire({
                    title: "Ocurrió un error",
                    text: error,
                    type: "error",
                    confirmButtonText: "Aceptar"
                });
            })
        },
        fixName(s) {
            let nombre = s.nombre_part+" "+s.ap_paterno+" "+s.ap_materno;
            return titleCase(nombre);
        }
    }
}
</script>
