<script>
export default {
    props: ['fields', 'url'],
    data() {
        return {
            form: new Form(this.fields)
        }
    },
    created() {
        console.log(this.fields);
    },
    methods: {
        onSubmit() {
            this.form.post(this.url).then(response => {
                window.location = this.url;
                // console.log(response);
            }).catch(error => console.log(error));
        },
    }
}
</script>
