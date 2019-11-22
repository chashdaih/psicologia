<template>
    <div>
        <a @click.prevent="modalVisible= true" class="button is-danger">
            <span class="icon"><fai icon="trash" size="2x" /></span>
        </a>
        <div class="modal" :class="{ 'is-active': modalVisible }">
            <div class="modal-background close-modal" @click="hide"></div>
                <div class="modal-card">
                    <header class="modal-card-head">
                    <p class="modal-card-title">Borrar plan de servicio<span id="span-id-cita"></span></p>
                    <button class="delete close-modal" aria-label="close" @click="hide"></button>
                </header>
                <section class="modal-card-body">
                    <div class="content">
                        <p>¿Está seguro que quiere eliminar el plan de servicio?</p>
                    </div>
                </section>
                <footer class="modal-card-foot">
                    <button class="button is-danger" :class="{'is-loading': isWaiting}" @click="deletePatient">Borrar</button>
                    <button class="button close-modal" @click="hide">Cancelar</button>
                </footer>
            </div>
        </div>
    </div>
</template>

<script>
import Swal from 'sweetalert2';
export default {
    props:['patientId', 'ps', 'baseUrl'],
    data() {
        return {
            modalVisible: false,
            isWaiting: false
        }
    },
    methods: {
        hide() {
            this.modalVisible = false;
        },
        deletePatient() {
            this.isWaiting=true;
            const url = `${this.baseUrl}/usuario/${this.patientId}/ps/${this.ps}`;
            axios.delete(url)
            .then(ans=>{
                 Swal.fire({
                    title: "Éxito",
                    type: "success",
                    text: "El plan de servicio fue eliminado.",
                    confirmButtonText: "Aceptar",
                    onClose: function() { location.reload(); }
                });
            })
            .catch(err=>{
                Swal.fire({
                    title: "Ocurrió un error",
                    text: err,
                    type: "error",
                    confirmButtonText: "Aceptar"
                });
            })
            .finally(()=> isWaiting=false);
        }
    }
}
</script>