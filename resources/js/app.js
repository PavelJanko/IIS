
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import { faCheck, faCheckSquare, faCogs, faHandPointDown, faPenSquare, faPlusSquare, faTimes, faTimesSquare } from '@fortawesome/pro-solid-svg-icons';
import { library as faLibrary }  from '@fortawesome/fontawesome-svg-core';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

faLibrary.add(faCheck, faCheckSquare, faCogs, faHandPointDown, faPenSquare, faPlusSquare, faTimes, faTimesSquare);
Vue.component('icon', FontAwesomeIcon);

// Set the moment.js localization to Czech
window.moment = require('moment');
moment.locale(process.env.MIX_APP_LOCALE);

window.swal = require('sweetalert2');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('chart', require('./components/ChartComponent.vue'));

const app = new Vue({
    el: '#app'
});
