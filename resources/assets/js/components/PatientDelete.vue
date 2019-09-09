<template>
    <div>
        <a @click.prevent="modalVisible= true" class="button is-danger">
            <span class="icon"><fai icon="trash" size="2x" /></span>
        </a>
        <div class="modal" :class="{ 'is-active': modalVisible }">
            <div class="modal-background close-modal" @click="hide"></div>
                <div class="modal-card">
                    <header class="modal-card-head">
                    <p class="modal-card-title">Borrar persona atendida<span id="span-id-cita"></span></p>
                    <button class="delete close-modal" aria-label="close" @click="hide"></button>
                </header>
                <section class="modal-card-body">
                    <div class="content">
                        <p>¿Está seguro que quiere eliminar al paciente <span class="has-text-weight-bold">{{fullName}}</span> con número de expediente <span class="has-text-weight-bold">{{fileNumber}}</span>?</p>
                    </div>
                </section>
                <footer class="modal-card-foot">
                    <button class="button is-danger" :class="{'is-loading': isWaiting}" @click="deletePatient">Borrar</button>
                    <button class="button close-modal" @click="hide">Cerrar</button>
                </footer>
            </div>
        </div>
    </div>
</template>

<script>
import Swal from 'sweetalert2';

export default {
    props:['fileNumber', 'fullName', 'url'],
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
            axios.delete(this.url)
            .then(ans=>{
                console.log(ans);
                 Swal.fire({
                    title: "Éxito",
                    type: "success",
                    text: "La persona atendida fue eliminada.",
                    confirmButtonText: "Aceptar",
                    onClose: function() {
                        location.reload();
                    }
                });
            })
            .catch(err=>{
                console.log(err);
                this.isWaiting=false;
                Swal.fire({
                    title: "Ocurrió un error",
                    text: error,
                    type: "error",
                    confirmButtonText: "Aceptar"
                });
            })
        }
    }
}
</script>