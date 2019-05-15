<script>
import TextInput from './TextInput';

export default {
    components: {
        TextInput
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
