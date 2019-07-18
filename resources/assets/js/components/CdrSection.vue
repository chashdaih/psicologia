<template>
    <div>
        <!-- <p class="title">{{ section.title }}</p> -->
        <table class="table is-fullwidth is-hoverable is-striped">
            <thead>
                <th>{{ section.time }}</th>
                <th v-for="(j, i) in 11" :key="j">{{i}}</th>
            </thead>
            <tbody>
                <tr v-for="(question, index) in section.questions" :key="index">
                    <td style="width:60%">{{ question }}</td>
                    <td v-for="(j, i) in 11" :key="j">
                        <input  type="radio" 
                                :value="i"
                                :name="section.title + index"
                                v-model="fields[section.title + index]"
                                >
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
export default {
    props: ['section'],
    data() {
        return {
            fields: {}
        }
    },
    created() {
        let questions = this.section.questions;
        for (let id in questions) {
            this.fields[this.section.title + id] = 0;
        }
    },
}
</script>
