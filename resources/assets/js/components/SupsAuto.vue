<template>
<div>
    <b-field label="Supervisor">
        <b-autocomplete
            v-model="name"
            placeholder="Busca un supervisor"
            :keep-first=true
            :open-on-focus=true
            :data="filteredDataObj"
            field="full_name"
            @select="option => {if(option) {selected = option.id_supervisor}}"
            :disabled="isDisabled"
            ref="autocomplete"
            >
        </b-autocomplete>
    </b-field>
    <input :name="field" type="hidden" :value="selected">
</div>
</template>

<script>
export default {
    props:['field', 'sups', 'user', 'dis'],
    data() {
        return {
            data: this.sups,
            name: '',
            selected: null,
            isDisabled: false
        }
    },
    computed: {
        filteredDataObj() {
            return this.data.filter((option) => {
                return option.full_name
                    .toString()
                    .toLowerCase()
                    .indexOf(this.name.toLowerCase()) >= 0
            })
        }
    },
    mounted() {
        if (this.dis) {
            this.isDisabled = true;
        }
        if (this.user) {
            this.$refs.autocomplete.setSelected(this.sups.find(obj => obj.id_supervisor==this.user));
        }
    }
}
</script>