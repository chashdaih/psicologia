<script>
import TextInput from './TextInput';
import DateComponent from './DateComponent';

const getAge = newDate => Math.floor((new Date() - newDate.getTime()) / 3.15576e+10);

export default {
    components: { TextInput, DateComponent },
    data() {
        return {
            is_under_18: false,
            second_tutor: false,
            is_unam: 0,
            requester: 0,
            age: null,
            has_work: '0',
            house_is: '0',
            previous_treatment: '0',
            has_recived_previous_treatment: '0',
            refer: '0',
            unam_prev: '0',
            has_health_issue: '0',
            takes_medication: '0'
        }
    },
    methods: {
        checkIfOver18(newDate) {
            this.age = getAge(newDate)
            this.is_under_18 = this.age < 18;
        },
        showSecondTutor() {
            this.second_tutor = true;
        }

    }
}
</script>
