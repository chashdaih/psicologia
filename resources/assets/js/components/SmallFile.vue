<template>
    <div class="field">
        <div class="file is-small is-boxed has-name is-centered" :class="error != '' ? 'is-danger' : color_class">
            <label class="file-label">
                <input class="file-input" :disabled="disable" type="file" :name="name" accept="image/jpeg,image/gif,image/png,application/pdf,image/x-eps" @change="onChange">
                <span class="file-cta">
                    <span class="file-icon">
                    <fai icon="upload" />
                    </span>
                    <span class="file-label">
                    Subir archivo
                    </span>
                </span>
                <span class="file-name" style="background-color:white;">
                    {{ file_name }}
                </span>
                <span>
                    <p class="help is-danger">{{ error }}</p>
                </span>
            </label>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        'serv_error': String,
        'name': String,
        'color': { default: 'is-warning' },
        'text': { default: 'Elige un archivo...' },
        'disable': { type: Boolean, default: false }
    },//['serv_error', 'name', 'color', 'text'],
    data(){
        return {
            file_name: this.text,
            error: this.serv_error,
            color_class: this.color
        }
    },
    methods: {
        onChange(e) {
            let file = e.target.files[0];
            if (file.size > 14000000) {
                this.error = 'El archivo debe ser menor a 14Mb';
                e.target.value = '';
                console.log(e.target);
                return;
            }
            this.error = '';
            this.file_name = e.target.files[0].name;
            this.color_class = 'is-info'
        }
    }
}
</script>
