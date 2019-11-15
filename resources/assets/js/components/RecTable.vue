<template>
    <div class="table-container">
        <b-table :data="patients" striped hoverable>
            <template slot-scope="props"> 
                <b-table-column label="No de exp." sortable field="file_number">{{props.row.file_number}}</b-table-column>
                <b-table-column label="Fecha de entrevista" sortable field="created_at">{{props.row.created_at}}</b-table-column>
                <b-table-column v-if="props.row.supName" label="Registrado_por_____" sortable field="supName">{{props.row.supName}}</b-table-column> 
                <!-- TODO hacer computed para este campo -->
                <b-table-column v-else label="Registrado_por_____" sortable field="parName">{{props.row.parName}}</b-table-column>
                <b-table-column label="Nombre_del_paciente" sortable field="patName">{{props.row.patName}}</b-table-column>
                <b-table-column label="Fecha de nacimiento" sortable field="birthdate">{{props.row.birthdate}}</b-table-column>
                <b-table-column label="Genero" sortable field="genero">{{props.row.genero}}</b-table-column>
                <b-table-column label="Edo. civil" sortable field="edoCivil">{{props.row.edoCivil}}</b-table-column>
                <b-table-column label="Nombre del responsable" sortable field="tutor_name_1">{{props.row.tutor_name_1}}</b-table-column>
                <b-table-column label="Alcaldía o municipio" sortable field="neighborhood">{{props.row.neighborhood}}</b-table-column>
                <b-table-column label="Teléfonos" sortable field="phones">{{props.row.phones}}</b-table-column>
                <b-table-column label="E-mail" sortable field="email">{{props.row.email}}</b-table-column>
                <b-table-column label="Nivel de estudios" sortable field="nivelEstudios">{{props.row.nivelEstudios}}</b-table-column>
                <b-table-column label="Trabaja" sortable field="has_work">{{props.row.has_work}}</b-table-column>
                <b-table-column label="Ocupación" sortable field="work_description">{{props.row.work_description}}</b-table-column>
                <b-table-column label="Ingreso familiar" sortable field="monthly_family_income">{{props.row.monthly_family_income}}</b-table-column>
                <b-table-column label="Dependientes económicos" sortable field="number_people_depending">{{props.row.number_people_depending}}</b-table-column>
                <b-table-column label="Integrantes del hogar" sortable field="household_members">{{props.row.household_members}}</b-table-column>
                <b-table-column label="Motivo_de_consulta_referido_por_el_paciente_______________________________________________________________________________________________________" sortable field="consultation_cause">{{props.row.consultation_cause}}</b-table-column>
                <b-table-column label="Tiempo transcurrido desde que comenzó la problemática" sortable field="problem_since">{{props.row.problem_since}}</b-table-column>
                <b-table-column label="Tratamientos anteriores" sortable field="has_recived_previous_treatment">{{props.row.has_recived_previous_treatment}}</b-table-column>
                <b-table-column label="Tipo de atención recibida" sortable field="atencionRecibida">{{props.row.atencionRecibida}}</b-table-column>
                <b-table-column label="Fue referido" sortable field="refer">{{props.row.refer}}</b-table-column>
                <b-table-column label="Institución canalizadora" sortable field="refer_where">{{props.row.refer_where}}</b-table-column>
                <b-table-column label="Diagnóstico de la institución" sortable field="refer_problem">{{props.row.refer_problem}}</b-table-column>
                <b-table-column label="Otros problemas de salud" sortable field="health_issue">{{props.row.health_issue}}</b-table-column>
                <b-table-column label="Toma medicamentos" sortable field="takes_medication">{{props.row.takes_medication}}</b-table-column>
                <b-table-column label="Nombre del medicamento" sortable field="medication">{{props.row.medication}}</b-table-column>
                <b-table-column label="Horario de preferencia" sortable field="horarioPreferencia">{{props.row.horarioPreferencia}}</b-table-column>
                <b-table-column label="Programa_asignado_______________" sortable field="programa">{{props.row.programa}}</b-table-column>
                <b-table-column label="Fecha de asignación" sortable field="fechaAsig">{{props.row.fechaAsig}}</b-table-column>
            </template>
        </b-table>
    </div>
</template>

<script>
export default {
    props: ['patients'],
    // data() {
    //     return {
    //         data: this.patients,
    //     }
    // }
}
</script>
