<template>
    <div>
        <b-field label="Filtrar por supervisor" horizontal>
            <b-autocomplete
                v-model="supName"
                placeholder="Selecciona un supervisor"
                :keep-first=true
                :open-on-focus=true
                :data="filteredDataObj"
                field="full_name"
                @select="option => {selectedSup = option.id_supervisor; filter();}"
                @focus="clearName"
                >
                <template slot="empty">No hay resultados para {{supName}}</template>
            </b-autocomplete>
        </b-field>
        <!-- <div class="field is-horizontal">
            <div class="field-label">
                <p>Filtrar por supervisor</p>
            </div>
            <div class="field-body">
                <div class="select">
                    <select v-model="selectedSup" @change="filter">
                        <option value=0 >Todos los supervisores</option>
                        <option v-for="(sup, index) in supervisors" :key="'s' + index" :value="sup.id_supervisor" >{{ sup.full_name }}</option>
                    </select>
                </div>
            </div>
        </div> -->
        <div class="field is-horizontal">
            <div class="field-label">
                <p>Filtrar por centro</p>
            </div>
            <div class="field-body">
                <div class="select">
                    <select v-model="selectedCenter" @change="filter()">
                        <option value=0>Todos los centros</option>
                        <option v-for="(center, index) in centers" :key="'c' + index" :value="center.id_centro" >{{ center.nombre }}</option>
                    </select>
                </div>
            </div>
        </div>
        <div v-for="program in prgrms" :key="program.id_practica" >
            <div class="card">
                <header class="card-header">
                    <p class="card-header-title">{{ program.programa }}</p>
                </header>
                <div class="card-content">
                    <div class="columns">
                        <div class="column">
                            <p class="has-text-weight-bold">Supervisor</p>
                            <p>{{ program.full_name }}</p>
                        </div>
                        <div class="column">
                            <p><span class="has-text-weight-bold">Duración (en semestres): </span>{{ program.periodicidad }}</p>
                            <p>{{ program.horario }}</p>
                        </div>
                    </div>
                    <p class="has-text-weight-bold">Resumen</p>
                    <p>{{ program.resumen }}</p>
                    <br>
                    <p class="has-text-weight-bold">Escenario</p>
                    <p>{{ program.nombre }}</p>
                </div>
                <footer class="card-footer">
                    <!-- {{ route('rps_pdf', $program->id_practica) }} -->
                    <a :href="pdfUrl + program.id_practica" class="card-footer-item">Ver programa completo</a>
                    <span class="card-footer-item">
                        <!-- {{ route('insc.enroll', $program->id_practica) }} -->
                        <form :action="enUrl + program.id_practica" method="POST" :ref="'form' + program.id_practica" >
                            <input type="hidden" name="_token" :value="csrf" />
                            <button class="button  is-primary is-outlined" type="button" @click="showModal(program)">Inscribirse al programa</button>
                        </form>
                    </span>
                </footer>
            </div>
            <br>
        </div>
        <div class="modal" :class="{ 'is-active': isActive }">
            <div class="modal-background" @click="hide"></div>
            <div class="modal-card">
                <header class="modal-card-head">
                    <p class="modal-card-title">Confirma tu pre-registro</p>
                    <button class="delete" aria-label="close" @click="hide"></button>
                </header>
                <section class="modal-card-body">
                    <ul>
                        <li>Programa: {{ selectedProgram.programa }}</li>
                        <li>Supervisor: {{ selectedProgram.full_name }}</li>
                        <li>Escenario: {{ selectedProgram.nombre }}</li>
                    </ul>
                    <br>
                    <div class="notification is-danger">
                        Recuerda que solo tienes dos semanas para subir tus documentos. <br>
                        En caso de no hacerlo, tu registro no será válido.
                    </div>
                </section>
                <footer class="modal-card-foot">
                    <button class="button is-success" @click="confirmReg">Confirmar pre-registro</button>
                    <button class="button" @click="hide">Cancelar</button>
                </footer>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props:['programs', 'pdfUrl', 'enUrl'],
    data() {
        return {
            prgrms: this.programs,
            selectedSup: 0,
            selectedCenter: 0,
            csrf: document.head.querySelector('meta[name="csrf-token"]').content,
            supervisors: [],
            centers: null,
            supName: 'Todos los supervisores',
            isActive: false,
            selectedProgram: {}
        }
    },
    methods: {
        filter() {
            this.prgrms = this.programs.filter((c) => {
                let sup = true;
                let center = true;
                if (this.selectedSup != 0) {
                    sup = (c.id_supervisor == this.selectedSup);
                }
                if (this.selectedCenter != 0) {
                    center = (c.id_centro == this.selectedCenter);
                }
                return sup && center;
            });
        },
        clearName() {
            this.supName = '';
        },
        showModal(program) {
            this.isActive = true;
            this.selectedProgram = program;
            // console.log(this.$refs['form' + this.selectedProgram.id_practica][0]);
        },
        hide() {
            this.isActive = false;
        },
        confirmReg() {
            this.$refs['form' + this.selectedProgram.id_practica][0].submit();
        }
    },
    mounted() {
        const all = [{'id_supervisor': 0, 'full_name': 'Todos los supervisores'}];
        this.supervisors = all.concat(Array.from(new Set(this.programs.map(a => a.id_supervisor)))
        .map(id => {
            return this.programs.find(a => a.id_supervisor === id);
        }));

        this.centers = Array.from(new Set(this.programs.map(a => a.id_centro)))
        .map(id => {
            return this.programs.find(a => a.id_centro === id);
        });
    },
    computed: {
        filteredDataObj() {
            return this.supervisors.filter((option) => {
                return option.full_name
                    .toString()
                    .toLowerCase()
                    .indexOf(this.supName.toLowerCase()) >= 0
            })
        }
    }
}
</script>
