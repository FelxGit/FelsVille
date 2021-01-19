import Vue from 'vue'
import router from './config/routes.js'
import axios from './config/axios.js'
import { store } from './store'
import Vuelidate from 'vuelidate'
Vue.use(Vuelidate)

import App from './views/App'

Vue.prototype.$http = axios
const app = new Vue({
    el: '#app',
    components: { App },
    router,
    store
})