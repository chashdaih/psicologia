<template>
  <form action="#">
        <b-field label="Filtrar por escenario" horizontal>
            <b-select
            v-model="selected_stage" 
            @input="filter()"
            placeholder="Selecciona un escenario">
            <option value=0>Todos los escenarios</option>
            <option style="width:50px;"
                v-for="stage in stages"
                :value=stage.id_centro
                :key=stage.id_centro
                >{{ stage.nombre }}</option>
            </b-select>
        </b-field>
        <table class="table">
            <thead>
                <tr>
                    <th>Nombre de la persona atendida</th>
                    <th>Programas asignados</th>
                    <th>Centros</th>
                    <th>Supervisores</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="patient in patients" :key="patient.id">
                    <td>{{patient.full_name}}</td>
                    <td>
                        <ul>
                            <li v-for="program in patient.programs" :key="program.id">{{program.programa}}</li>
                        </ul>
                    </td>
                </tr>
            </tbody>
        </table>
  </form>
</template>

<script>
export default {

}
</script>