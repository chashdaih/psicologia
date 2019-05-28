<script>
import TextInput from './TextInput';
import RelatedInput from './RelatedInput';

export default {
    components: {
        TextInput, RelatedInput
    },
    props: {
        sups: {
            default: 1,
            type: Number
        },
        old: {
            default: null,
            type: Number
        }
    },
    data() {
        return {
            rows: this.sups,
            visible: new Array(this.old).fill(true),
            csrf: document.head.querySelector('meta[name="csrf-token"]').content
        }
    },
    methods: {
        addRow() {
            this.rows++;
        },
        deleteRow(e) {
           this.rows--;
        },
        deleteOld(url) {
            let targetId = event.currentTarget.id;
            Vue.set(this.visible, targetId, false);

            axios.get(url)
            .then(function (response) {
                console.log(response);
            })
            .catch(function (error) {
                console.log(error);
            });
        }
    }
}
</script>
