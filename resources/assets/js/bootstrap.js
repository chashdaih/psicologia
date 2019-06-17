import Vue from 'vue';
import axios from 'axios';

import Form from './utilities/Form';

window.Vue = Vue;

import Buefy from 'buefy';
// import 'buefy/dist/buefy.css';
Vue.use(Buefy, {
    defaultDayNames: ['D', 'L', 'Ma', 'Mi', 'J', 'V', 'S'],
    defaultMonthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
    // defaultIconComponent: 'vue-fontawesome',
    // defaultIconPack: 'fas'
});

window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.Form = Form;