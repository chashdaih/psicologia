<template>
    <div>
        <a href="#" @click.prevent="isModalActive = true" class="button is-success">Registrar participante al programa</a>

        <b-modal :active.sync="isModalActive"  >
            <header class="modal-card-head">
                <p class="modal-card-title">Registrar participante al programa: "{{program.programa}}"</p>
            </header>
            <section class="modal-card-body" style="height:50vh;">
                <b-field label="Busca por nombre, apellido o número de cuenta">
                    <b-autocomplete
                        rounded
                        :data="data"
                        placeholder="Busca por nombre, apellido o número de cuenta"
                        :loading="isFetching"
                        @typing="getAsyncData"
                        @select="selected"
                    >
                        <template slot-scope="props">
                            <p>{{props.option.num_cuenta}} - {{props.option.full_name}}</p>
                        </template>
                    </b-autocomplete>
                </b-field>
                <p class="is-italic">Haz click en el resultado de la búsqueda para registrarlo.</p>
            </section>
            <footer class="modal-card-foot">
                <button class="button" type="button" @click="isModalActive=false">Cancelar</button>
            </footer>
        </b-modal>
    </div>
</template>

<script>
import debounce from 'lodash/debounce';
import Swal from 'sweetalert2';
export default {
    props:['program', 'url'],
    data() {
        return {
            isModalActive: false, 
            data: [],
            isFetching: false
        }
    },
    methods: {
        getAsyncData: debounce(function (term) {
            if (!term.length) {
                this.data = [];
                return;
            }
            this.isFetching = true;
            axios.get(this.url + '/partaker/search/' + term)
            .then(({data})=>{
                this.data = [];
                data.forEach(item=>this.data.push(item));
            })
            .catch(error=>{
                this.data = [];
                throw error;
            })
            .finally(()=>{this.isFetching = false})
            }, 
        500),

        selected(option) {
            console.log(option.num_cuenta);
            const url = this.url +  "/program/" + this.program.id_practica + "/partakers/register";
            const data = { partaker_id: option.num_cuenta };
            axios.post(url, data)
            .then(()=>{
                Swal.fire({
                    title: "Éxito",
                    type: "success",
                    text: "El participante se registró correctamente.",
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
            });
        }
    }
}
</script>