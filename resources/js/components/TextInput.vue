<script>
export default {
    props: {
        error:{
            type: Boolean,
            default: false
        },
        title: {
            type: String,
        }
    },
    // props:['test'],
    data() {
        return {
            hasError: this.error,
        }
    },
    methods: {
        clearError() {
            if (this.hasError) {
                this.hasError = false;
                this.$refs[this.title].classList.remove('is-danger');
            }
        }
    }
}
</script>
