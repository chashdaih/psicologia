import './bootstrap';

import LoginForm from './components/LoginForm';
import ListCheckbox from './components/ListCheckbox';
import CalendarModal from './components/CalendarModal';
import CalDateSel from './components/CalDateSel';
import CalCancelModal from './components/CalCancelModal';
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
import RelatedInput from './components/RelatedInput';
import AddRow from './components/AddRow';
import SupsTable from './components/SupsTable';
import ProgramsList from './components/ProgramsList';

import { library } from '@fortawesome/fontawesome-svg-core';
import { faFileCode, faFilePdf, faCheck, faTimes, faUpload, faClone, faFileUpload, faTrash } from '@fortawesome/free-solid-svg-icons';
library.add(faFileCode, faFilePdf, faCheck, faTimes, faUpload, faClone, faFileUpload, faTrash);
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
        CalCancelModal,
        CalendarSpace,
        CalDateSel,
        FDGForm,
        CdrForm,
        Test,
        EcprForm,
        CollapsibleCard,
        FileInput,
        SmallFile,
        TextInput,
        SortableTable,
        RelatedInput,
        AddRow,
        SupsTable,
        ProgramsList
    },
    data: {
        isActive: false
    },
    methods: {
        toggleMenu() {
            this.isActive = !this.isActive;
        }
    },
    mounted() {
        let csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;

        setInterval(refreshToken, 3600000); // 1 hour 

        function refreshToken(){
            axios.get('refresh-csrf').then((data)=>{
                csrfToken = data.data; // the new token
            });
        }

        setInterval(refreshToken, 3600000); // 1 hour 
    }
});
