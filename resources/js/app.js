import './bootstrap';

import LoginForm from './components/LoginForm';
import ListCheckbox from './components/ListCheckbox';
import CalendarModal from './components/CalendarModal';


// Vue.component('example-component', require('./components/ExampleComponent.vue').default);

const app = new Vue({
    el: '#app',
    components: {
        LoginForm,
        ListCheckbox,
        CalendarModal
    },
    methods: {
        openModal() {
            console.log('open modal');
        }
    }
});
