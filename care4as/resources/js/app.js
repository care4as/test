/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import axios from 'axios'
import Vue from 'vue'
window.Dropzone = require('dropzone');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('simulator', require('./components/TrainingsSimulator.vue').default);
Vue.component('trackchart', require('./components/Tracker.vue').default);
Vue.component('ptable', require('./components/performanceTable.vue').default);
Vue.component('ptablealt', require('./components/performanceTableAlt.vue').default);

Vue.component('ptool', require('./components/pausetracker.vue').default);
Vue.component('timetracker', require('./components/TimeTracking.vue').default);
Vue.component('ships', require('./components/ships.vue').default);
Vue.component('dbmonitor', require('./components/dashboardMonitor.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
const app2 = new Vue({
    el: '#worktimeconsole',
});
