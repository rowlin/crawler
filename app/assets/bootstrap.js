import Vue from 'vue';

//import store from './store.js';
Vue.component('modal', require('./components/Modal').default )
Vue.component('topPanel', require('./components/TopPanel').default )
new Vue({
    el: '#app',
})
