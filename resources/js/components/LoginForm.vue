<template>
    <form @submit.prevent="onSubmit" @keydown="form.errors.clear($event.target.name)" >
        <div class="field">
            <label class="label">Correo electrónico</label>
            <p class="control has-icons-left has-icons-right">
                <input class="input" type="email" placeholder="Correo electrónico" v-model="form.email" >
                <span class="icon is-small is-left">
                    <!-- <i class="fas fa-envelope"></i> -->
                    <fai icon="envelope" />
                </span>
            </p>
            <span class="help is-danger" v-if="form.errors.has('email')" v-text="form.errors.get('email')"></span>
        </div>
        <div class="field">
            <label class="label">Contraseña</label>
            <p class="control has-icons-left">
                <input class="input" type="password" placeholder="Contraseña" v-model="form.password" >
                <span class="icon is-small is-left">
                    <!-- <i class="fas fa-lock"></i> -->
                    <fai icon="lock" />
                </span>
            </p>
            <span class="help is-danger" v-if="form.errors.has('password')" v-text="form.errors.get('password')"></span>
        </div>
        <div class="field">
            <p class="control">
                <button class="button is-success" v-bind:class="{ 'is-loading': form.isLoading }" :disabled="form.errors.any()" >Iniciar sesión</button>
            </p>
        </div>
    </form>
</template>

<script>
import { library } from '@fortawesome/fontawesome-svg-core';
import { faEnvelope, faLock } from '@fortawesome/free-solid-svg-icons';
library.add(faEnvelope, faLock);

export default {
    props: ['url', 'redirect'],
    data() {
        return {
            form: new Form({ email: '', password: '' })
        }
    },
    methods: {
        onSubmit() {
            this.form.post(this.url).then(response => {
                window.location = this.redirect;
                // console.log(response);
            });
        }
    }
}
</script>
