<template>
  <input type="text"
    placeholder="0 - 100"
    :name="name"
    v-model="newVal"
    @input="checkNumber"
    :class="clazz"
  >
</template>

<script>
export default {
    props: {
        'name': { type: String, },
        'value': { required: true },
        'clazz': { default: 'input', },
    },
    data() {
        return {
            newVal: this.value,
            // klass: this.clazz,
        }
    },
    methods: {
        checkNumber(e) {
            let regexp = new RegExp("[^0-9]", "g");
            this.newVal = this.newVal.replace(regexp, "");
            if (this.newVal > 101) {
                this.newVal = this.newVal.substring(1, 2);
            }
        }
    }

}
</script>