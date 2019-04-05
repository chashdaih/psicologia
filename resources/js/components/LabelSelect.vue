<template>
    <div class="field is-horizontal">
        <div class="field-label">
            <label class="label"><slot></slot></label>
        </div>
        <div class="field-body">
            <div class="field">
                <div class="control">
                    <div class="select is-info">
                        <select v-model="inputVal">
                            <option v-for="(item, index) in items" :key="index" :value="index">{{ item }}</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['value', 'items'],
    data() {
        return {
            inputVal: this.value
        }
    },
    watch: {
        inputVal(val) {
            this.$emit('input', val);
        }
    }
}
</script>

