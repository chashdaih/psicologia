<template>
    <input type="text" class="input"
        placeholder="0 - 6"
        min="0"
        max="6"
        :name="name"
        style="min-width: 50px"
        v-model="newVal"
        @input="checkNumber"
    />
</template>

<script>
export default {
    props: ['name', 'value'],
    data() {
        return {
            newVal: this.value,
        }
    },
    methods: {
        checkNumber(e) {
            this.newVal = this.newVal.replace(/[^0-6]+/g, "");
            if (this.newVal.length > 1) {
                this.newVal = this.newVal.substring(1, 2);
            }
        }
    }
}
</script>