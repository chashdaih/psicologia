<template>
    <b-collapse
        aria-id="changePassword"
        class="card"
        :open="false"
    >
        <div
            slot="trigger"
            slot-scope="props"
            class="card-header"
            role="button"
            aria-controls="changePassword"
        >
            <p class="card-header-title">Cambiar contraseña</p>
            <a class="card-header-icon">
                <fai :icon="props.open ? 'angle-up' : 'angle-down'" />
            </a>
        </div>
        <div class="card-content">
            <b-field label="Nueva contraseña"
                :type="{'is-danger':hasError}"
            >
                <b-input type="password"
                    v-model="newPass"
                    password-reveal>
                </b-input>
            </b-field>
            <b-field label="Repetir nueva contraseña"
                :type="{'is-danger':hasError}"
                :message="errorMsg"
            >
                <b-input type="password"
                    v-model="passConf"
                    password-reveal>
                </b-input>
            </b-field>
            <b-button type="is-success" :loading="isChanging" @click="changePass">Actualizar</b-button>
        </div>
    </b-collapse>
</template>

<script>
import Swal from 'sweetalert2';

export default {
    props: ['url', 'userId'],
    data() {
        return {
            newPass: '',
            passConf: '',
            hasError: false,
            errorMsg: '',
            isChanging: false
        }
    },
    methods: {
        clearErrors() {
            this.hasError = false;
            this.errorMsg = '';
        },
        changePass() {
            this.clearErrors();
            if (this.newPass == '' || this.passConf == '') {
                this.hasError = true;
                this.errorMsg = 'La contraseña no puede ser nula';
                return;
            }
            if (this.newPass != this.passConf) {
                this.hasError = true;
                this.errorMsg = 'Las contraseñas no coinciden';
                return;
            }
            this.isChanging = true;
            const url = `${this.url}/supervisor/${this.userId}/changePass`;
            axios.post(url, {newPass: this.newPass})
            .then(
                Swal.fire({
                    title: "Éxito",
                    type: "success",
                    text: "La contraseña se actualizó correctamente",
                    confirmButtonText: "Aceptar",
                })
            )
            .catch(err=>{
                Swal.fire({
                    title: "Ocurrió un error",
                    text: err,
                    type: "error",
                    confirmButtonText: "Aceptar"
                });
            })
            .finally(()=>this.isChanging=false);
        }
    },
    watch: {
        newPass() {
            this.clearErrors();
        },
        passConf() {
            this.clearErrors();
        }
    }
}
</script>