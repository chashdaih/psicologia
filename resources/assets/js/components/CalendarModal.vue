<template>
    <div class="modal" :class="{ 'is-active': isActive }">
        <div class="modal-background" @click="hide"></div>
        <div class="modal-card">
            <header class="modal-card-head">
                <p class="modal-card-title">Agendar nueva cita</p>
                <button class="delete" aria-label="close" @click="hide"></button>
            </header>
            <section class="modal-card-body">
                <!-- Content ... -->
                Aquí va el form
            </section>
            <footer class="modal-card-foot">
                <button class="button is-success">Agendar cita</button>
                <button class="button" @click="hide">Cancelar</button>
            </footer>
        </div>
    </div>
</template>

<script>
import { eventBus } from '../app.js';
export default {
    data() {
        return {
            isActive: false,
            data: null
        }
    },
    created() {
        eventBus.$on('detail-modal', data => {
            this.isActive = true;
            this.data = data;
        });
    },
    methods: {
        hide() {
            this.isActive = false;
        },
        // show(id) {
        //     console.log(id);
        //     this.isActive = true;
        // }
    }
}
</script>
