import './bootstrap';

import LoginForm from './components/LoginForm';
import ListCheckbox from './components/ListCheckbox';
import CalendarModal from './components/CalendarModal';
import CalendarSpace from './components/CalendarSpace';
import FDGForm from './components/FDGForm';
import CdrForm from './components/CdrForm';
import Test from './components/Test';
import EcprForm from './components/EcprForm';
import CollapsibleCard from './components/CollapsibleCard';
import FileInput from './components/FileInput';
import SmallFile from './components/SmallFile';
import TextInput from './components/TextInput';
import SortableTable from './components/SortableTable';

import { library } from '@fortawesome/fontawesome-svg-core';
import { faFileCode, faFilePdf, faCheck, faTimes, faUpload, faClone, faFileUpload } from '@fortawesome/free-solid-svg-icons';
library.add(faFileCode, faFilePdf, faCheck, faTimes, faUpload, faClone, faFileUpload);
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

export const eventBus = new Vue();

Vue.component('fai', FontAwesomeIcon);

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
        Test,
        EcprForm,
        CollapsibleCard,
        FileInput,
        SmallFile,
        TextInput,
        SortableTable
    }
});
