import './bootstrap';

import LoginForm from './components/LoginForm';
import ListCheckbox from './components/ListCheckbox';
import CalendarModal from './components/CalendarModal';
import CalendarSpace from './components/CalendarSpace';
import FDGForm from './components/FDGForm';
import CdrForm from './components/CdrForm';
import Test from './components/Test';

export const eventBus = new Vue();

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);

const app = new Vue({
    el: '#app',
    components: {
        LoginForm,
        ListCheckbox,
        CalendarModal,
        CalendarSpace,
        FDGForm,
        CdrForm,
        Test
    }
});
