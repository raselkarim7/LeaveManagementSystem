import Vue from 'vue'
import Router from 'vue-router'

import Welcome from './views/Welcome.vue'
import Test from './views/Test.vue'; 
Vue.use(Router)

const routes = [
    {
        path: '/',
        name: 'welcome', 
        component: Welcome
    }, 
    {
        path: '/test-view',
        name: 'TestView', 
        component: Test 
    }
]

const router = new Router({
    routes: routes, 
    linkExactActiveClass: 'active'
})

export default router; 