<template>
    <div class="field">
        <div class="file is-centered is-boxed has-name" :class="error != '' ? 'is-danger' : 'is-success'">
            <label class="file-label">
                <input class="file-input" type="file" name="upload_file" accept="application/pdf" @change="onChange" required>
                <span class="file-cta">
                    <span class="file-icon">
                    <fai icon="upload" />
                    </span>
                    <span class="file-label">
                    Subir archivo
                    </span>
                </span>
                <span class="file-name">
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
    props: ['serv_error'],
    data(){
        return {
            file_name: "Elige un archivo...",
            error: this.serv_error
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
        }
    }
}
</script>
