<template>
    <div>
        <a @click.prevent="modalVisible= true" class="button is-danger">
            <span class="icon"><fai icon="trash" size="2x" /></span>
        </a>
        <div class="modal" :class="{ 'is-active': modalVisible }">
            <div class="modal-background close-modal" @click="hide"></div>
                <div class="modal-card">
                    <header class="modal-card-head">
                    <p class="modal-card-title">Borrar {{docTitle}}<span id="span-id-cita"></span></p>
                    <button class="delete close-modal" aria-label="close" @click="hide"></button>
                </header>
                <section class="modal-card-body">
                    <div class="content">
                        <p>¿Está seguro que quiere eliminar el documento?</p>
                    </div>
                </section>
                <footer class="modal-card-foot">
                    <button class="button is-danger" :class="{'is-loading': isWaiting}" @click="deleteDoc">Borrar</button>
                    <button class="button close-modal" @click="hide">Cancelar</button>
                </footer>
            </div>
        </div>
    </div>
</template>

<script>
import Swal from 'sweetalert2';
export default {
    props: {
        docTitle: { type: String, default: 'documento' },
        fullUrl: { type: String, required: true },
    },
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
        deleteDoc() {
            this.isWaiting=true;
            axios.delete(this.fullUrl)
            .then(ans=>{
                 Swal.fire({
                    title: "Éxito",
                    type: "success",
                    text: `El documento fue eliminado`,
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
            .finally(()=> this.isWaiting=false);
        }
    }
}
</script>