<template>
    <div class="field is-horizontal">
        <div class="field-label is-normal">
            <label class="label">Cambiar fecha</label>
        </div>
        <div class="field-body">
            <div class="field">
            <p class="control">
                <input type="date" class="input" v-model="selFecha" @change="dateChange"/>
            </p>
            </div>
        </div>
    </div>
</template>


<script>
export default {
    props:['fecha', 'url'],
    data(){
        return {
            selFecha: this.fecha
        }
    },
    methods: {
        dateChange() {
            location.href = this.url + "/" + this.selFecha;
        }
    }
}
</script>
