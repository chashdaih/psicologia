<template>
    <div>
        <a @click.prevent="isVisibleChooser=true" class="button is-info">Elegir programa</a>
        <assign-program
                :supervisors="supervisors"
                :etapa="stage"
                :base_url="baseUrl"
                :user_id="userId"
                :isVisible="isVisibleChooser"
                :semesters="semesters"
                v-on:hide-assign="isVisibleChooser=false"
                v-on:patient-assigned="reload"
            ></assign-program>
    </div>
</template>
<script>
import AssignProgram from './AssignProgram';
export default {
    props: ['stage', 'baseUrl', 'userId', 'supervisors', 'semesters'],
    components: { AssignProgram, },
    data() {
        return {
            isVisibleChooser: false
        }
    },
    methods: {
        reload() {
            window.location.reload()
        }
    }

}
</script>