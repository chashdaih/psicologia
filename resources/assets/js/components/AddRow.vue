<script>
import TextInput from './TextInput';
import RelatedInput from './RelatedInput';

export default {
    components: {
        TextInput, RelatedInput
    },
    data() {
        return {
            rows: 1
        }
    }, 
    methods: {
        addRow() {
            this.rows++;
        }
    }
}
</script>
