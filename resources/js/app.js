import Vue  from 'vue'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap'

import BootstrapVue from 'bootstrap-vue'
Vue.use(BootstrapVue)

import FlashMessage from '@smartweb/vue-flash-message'
Vue.use(FlashMessage)

import router from './router.js'
import store from './store/store.js'
import App from './App.vue'

new Vue({
    el: '#app',
    store,
    router, 
    render: h => h(App)
});
