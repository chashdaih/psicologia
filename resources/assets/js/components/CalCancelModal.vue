<template>
    <div class="modal" :class="{ 'is-active': isActive }">
        <div class="modal-background close-modal" @click="hide"></div>
            <div class="modal-card">
                <header class="modal-card-head">
                <p class="modal-card-title">Cancelar cita <span id="span-id-cita"></span></p>
                <button class="delete close-modal" aria-label="close" @click="hide"></button>
            </header>
            <section class="modal-card-body">
                <div class="content">
                    <p>¿Está seguro que quiere cancelar esta cita?</p>
                </div>
            </section>
            <footer class="modal-card-foot">
                <button class="button is-danger" @click="cancelAppo">Cancelar cita</button>
                <button class="button close-modal" @click="hide">Cerrar</button>
            </footer>
        </div>
    </div>
</template>

<script>
import { eventBus } from '../app.js';
import Swal from 'sweetalert2';

export default {
    props:['url'],
    data() {
        return {
            isActive: false,
            cancel_id: 0,
        }
    },
    created() {
        eventBus.$on('cancel-modal', data => {
            this.isActive = true;
            this.cancel_id = data.id_cita;
            console.log(this.cancel_id);
        });
    },
    methods: {
        hide() {
            this.isActive = false;
        },
        cancelAppo() {
            axios.delete(this.url + this.cancel_id)
            .then(()=>{
                Swal.fire({
                    title: "Éxito",
                    type: "success",
                    text: "La cita se canceló exitosamente",
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
        }
    }
    
}
</script>

