<script>
export default {
    props: {
        error:{
            type: Boolean,
            default: false
        },
        title: {
            type: String,
        },
        type: {
            type: String,
            default: null
        }
    },
    // props:['test'],
    data() {
        return {
            hasError: this.error,
            // hasNumber: this.type
        }
    },
    methods: {
        clearError() {
            if (this.hasError) {
                this.hasError = false;
                this.$refs[this.title].classList.remove('is-danger');
            }
        },
        isNumber: function(evt) {
            // console.log(this.type)
            if(this.type == "number") {
                evt = (evt) ? evt : window.event;
                var charCode = (evt.which) ? evt.which : evt.keyCode;
                if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
                    evt.preventDefault();
                } else {
                    return true;
                }
            }
        }
    }
}
</script>
