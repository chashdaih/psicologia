<template>
<div>
    <form :action="url" ref="form" method="POST">
        <slot></slot>
        <input type="hidden" name="_method" value="delete" />
        <button class="button is-danger" @click.prevent="isModalActive = true">
            <fai icon="sign-out-alt" size="2x" />
        </button>
    </form>
    <b-modal :active.sync="isModalActive" >
        <div class="modal-card">
            <header class="modal-card-head">
                <p class="modal-card-title">Dar de baja participante</p>
            </header>
            <section class="modal-card-body">
                <p>¿Está seguro que quiere dar de baja a <span class="is-italic">{{partaker}}</span> del programa <span class="is-italic">{{program}}</span>?</p>
            </section>
            <footer class="modal-card-foot">
                <button class="button" type="button" @click="isModalActive=false">Cancelar</button>
                <button class="button is-danger" @click="submit" >Dar de baja</button>
            </footer>
        </div>
    </b-modal>
</div>
</template>

<script>
export default {
    props:['url', 'program', 'partaker'],
    data(){
        return {
            isModalActive:false
        }
    },
    methods:{
        submit: function() {
            this.$refs.form.submit();
        }
    }
    // created(){
    //     console.log(this.url);
    // }
}
</script>
