import Vue from 'vue'
import Router from 'vue-router'

import Dashboard from './views/Dashboard.vue'
import Test from './views/Test.vue'; 
Vue.use(Router)

const routes = [

    {
        path: '/home',
        name: 'Home', 
        component: () => import('./views/Home.vue'), 
        children: [
            {
                path: '',
                name: 'dashboard', 
                component: Dashboard
            }, 
            {
                path: 'test-view',
                name: 'TestView', 
                component: Test 
            }, 
        ]
    }, 
    {
        path: '/register',
        name: 'Register', 
        component: () => import('./views/authentication/Register.vue') 
    }, 
    {
        path: '/login',
        name: 'Login', 
        component: () => import('./views/authentication/Login.vue') 
    }, 
    {
        path: '/reset-password',
        name: 'ResetPassword', 
        component: () => import('./views/authentication/ResetPassword.vue') 
    }, 
    

]

const router = new Router({
    routes: routes, 
    linkExactActiveClass: 'active'
})

export default router; 