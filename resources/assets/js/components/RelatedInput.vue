<script>
import TextInput from './TextInput';
import SupsAuto from './SupsAuto';

export default {
    components: {
        TextInput,SupsAuto
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
