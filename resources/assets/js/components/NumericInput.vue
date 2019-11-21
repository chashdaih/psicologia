<template>
    <input type="text"
        :placeholder="`0 - ${max}`"
        :name="name"
        style="min-width: 50px"
        v-model="newVal"
        @input="checkNumber"
        :class="clazz"
    />
</template>

<script>
export default {
    props: {
        'name': { type: String, },
        'value': { required: true },
        'max': { default: 6 },
        'clazz': { default: 'input', },
    },
    data() {
        return {
            newVal: this.value,
        }
    },
    methods: {
        checkNumber(e) {
            let regString = `[^0-${this.max}]+`
            let regexp = new RegExp(regString, "g");
            this.newVal = this.newVal.replace(regexp, "");
            if (this.newVal.length > 1) {
                this.newVal = this.newVal.substring(1, 2);
            }
        }
    }
}
</script>