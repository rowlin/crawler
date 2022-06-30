import Vue from 'vue';

//import store from './store.js';
window.axios = require('axios');
import { library } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import * as bulmaToast from 'bulma-toast'
Vue.component('font-awesome-icon', FontAwesomeIcon)
Vue.component('modal', require('./components/Modal').default )
Vue.component('topPanel', require('./components/TopPanel').default )
Vue.component('cardList', require('./components/CardList').default )

new Vue({
    el: '#app',
})
