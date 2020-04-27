import Vue  from 'vue';
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap';

import router from './router.js'; 
import App from './App.vue';

new Vue({
    el: '#app',
    router, 
    render: h => h(App)
});
