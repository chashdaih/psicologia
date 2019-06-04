<template>
    <div>
        <div class="field is-horizontal">
            <div class="field-label">
                <p>Filtrar por supervisor</p>
            </div>
            <div class="field-body">
                <div class="select">
                    <select v-model="selectedSup" @change="filterSup">
                        <option value="0" >Todos los supervisores</option>
                        <option v-for="sup in programs" :key="sup.id_practica" :value="sup.id_supervisor" >{{ sup.full_name }}</option>
                    </select>
                </div>
            </div>
        </div>
        <!-- <div class="field is-horizontal">
            <div class="field-label">
                <p>Filtrar por centro</p>
            </div>
            <div class="field-body">
                <div class="select">
                    <select v-model="selectedSup" @change="filterCenter">
                        <option value="0">Todos los centros</option>
                        <option v-for="center in programs" :key="center.id_centro" :value="center.id_centro" >{{ center.nombre }}</option>
                    </select>
                </div>
            </div>
        </div> -->
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
                        <form :action="enUrl + program.id_practica" method="POST" >
                            <input type="hidden" name="_token" :value="csrf" />
                            <button class="button  is-primary is-outlined" type="submit">Inscribirse al programa</button>
                        </form>
                    </span>
                </footer>
            </div>
            <br>
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
        }
    },
    methods: {
        filterSup() {
            if (this.selectedSup == 0) {
                this.prgrms = this.programs;
                return;
            }
            this.prgrms = this.programs.filter((c) => {
                return c.id_supervisor == this.selectedSup;
            });
        },
        filterCenter() {
            if (this.selectedCenter == 0) {
                this.prgrms = this.programs;
                return;
            }
            this.prgrms = this.programs.filter((c) => {
                return c.id_centro == this.selectedCenter;
            });

        }
    }
}
</script>
