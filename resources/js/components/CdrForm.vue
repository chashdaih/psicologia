<template>
    <form @submit.prevent="onSubmit">
        <div class="field is-horizontal">
            <div class="field-label">
                <label class="label">Paciente</label>
            </div>
            <div class="field-body">
                <div class="field">
                    <div class="control">
                        <div class="select is-info">
                            <select v-model="form.FE3FDG_id" required>
                                <option value="0" disabled>Por favor, seleccione un paciente</option>
                                <option v-for="fdg in fdgs" :value="fdg.id" :key="fdg.id">{{ fdg.name + " " + fdg.last_name + " " + fdg.mothers_name }}</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="field is-horizontal">
            <div class="field-label">
                <label class="label">Centro en el que será atendido</label>
            </div>
            <div class="field-body">
                <div class="field">
                    <div class="control">
                        <div class="select is-info">
                            <select v-model="form.center">
                                <option value="0" disabled>Por favor, seleccione un centro</option>
                                <option v-for="program in programs" :key="program.id_centro" :value="program.id_centro">{{ program.nombre }}</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="field is-horizontal">
            <div class="field-label">
                <label class="label">Programa</label>
            </div>
            <div class="field-body">
                <div class="field">
                    <p class="control">
                        <input type="text" class="input" placeholder="Programa" v-model="form.program" required>
                    </p>
                    <span class="help is-danger" v-if="form.errors.has('program')" v-text="form.errors.get('program')"></span>
                </div>
            </div>
        </div>
        <cdr-section v-for="section in sections" :key="section.title" :section="section" @update-field="updateField"></cdr-section>
        <button class="button" type="submit">Enviar</button>
    </form>
</template>
<script>
import CdrSection from './CdrSection';
export default {
    components: {
        CdrSection,
    },
    props: ['sections', 'url', 'redirect', 'fdgs', 'programs'],
    data() {
        return {
            // fields: {},
            form: null
        }
    },
    created() {
        let fields = {FE3FDG_id:0, center:0, program: '', student: 1, supervisor: 1};
        for (let section in this.sections) {
            let questions = this.sections[section].questions;
            for (let id in questions) {
                fields[this.sections[section].title + id] = 0;
            }
        }
        this.form = new Form(fields);
    },
    methods: {
        updateField: function(field, value) {
            this.form[field] = value;
        },
        onSubmit() {
            this.form.post(this.url).then(response => {
                window.location = this.redirect;
                // console.log(response);
            }).catch(error => console.log(error));
        },
    }
}
</script>
