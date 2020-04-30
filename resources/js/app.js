import Vue  from 'vue'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap'

import BootstrapVue from 'bootstrap-vue'
Vue.use(BootstrapVue)

import FlashMessage from '@smartweb/vue-flash-message'
Vue.use(FlashMessage)

import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
Vue.use(VueSweetalert2)



import router from './router.js'
import store from './store/store.js'
import App from './App.vue'

export default new Vue({
    el: '#app',
    store,
    router, 
    render: h => h(App)
});
