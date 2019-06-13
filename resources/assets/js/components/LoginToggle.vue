<script>
import TextInput from './TextInput';
export default {
    components: {
        TextInput
    },
    data() {
        return {
            students:false,
            supervisors: false,
        };
    },
    methods: {
        showStudents() {
            this.students = true;
            this.supervisors = false;
        },
        showSupervisors() {
            this.students = false;
            this.supervisors = true;
        }
    }
}
</script>
