<template>
  <form action="#">
        <b-table :data="patients" >
            <template slot-scope="props">
                <b-table-column field="file_number" label="No. expediente" sortable >
                    {{props.row.file_number}}
                </b-table-column>
                <b-table-column field="curp" label="No. cuenta / No. trabajador / CURP" sortable >
                    {{props.row.curp}}
                </b-table-column>
                <b-table-column field="programs" label="Programas" sortable >
                    <ul>
                        <li v-for="(program, index) in props.row.programs" :key="index">{{program}}</li>
                    </ul>
                </b-table-column>
                <b-table-column field="centers" label="Centros" sortable >
                    <ul>
                        <li v-for="(center, index) in props.row.centers" :key="index">{{center}}</li>
                    </ul>
                </b-table-column>
                <b-table-column field="supervisors" label="Supervisores" sortable >
                    <ul>
                        <li v-for="(supervisor, index) in props.row.supervisors" :key="index">{{supervisor}}</li>
                    </ul>
                </b-table-column>
                <b-table-column label="Ir a procesos" >
                    <a :href="baseUrl + '/' + props.row.id">
                        <fai icon="arrow-circle-right" size="2x" />
                    </a>
                </b-table-column>
            </template>
        </b-table>
  </form>
</template>

<script>
export default {
    props: ['baseUrl', 'patients'],
    // data() {
    //     return {
    //         pats: this.patients,
    //         programs: {},
    //         supervisors: [],
    //         centers: {},
    //         supName: 'Todos los supervisores',
    //     }
    // }
    // created(){
    //     this.patients.map(pat => {
    //         for (const index in pat.programs) {
    //             this.programs[index] = pat.programs[index];
    //         }
    //         for (const index in pat.centers) {
    //             this.centers[index] = pat.centers[index];
    //         }
    //         for (const index in pat.supervisors) {
    //             if (!this.supervisors.includes(pat.supervisors[index])) {
    //                 this.supervisors.push(pat.supervisors[index]);
    //             }
    //         }
    //     })
    // },
}
</script>