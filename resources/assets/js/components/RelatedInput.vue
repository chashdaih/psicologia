<script>
import TextInput from './TextInput';

export default {
    components: {
        TextInput
    },
    props: {
        oldValue: { default: 0 }
    },
    data() {
        return {
            selected: this.oldValue
        }
    }
}
</script>
