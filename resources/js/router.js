import Vue from 'vue'
import Router from 'vue-router'
Vue.use(Router)

import Dashboard from './views/Dashboard.vue'
import Test from './views/Test.vue'; 
import * as auth from './services/auth_service'; 

const routes = [
    {
        path: '/home', 
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
        ], 
        beforeEnter(to, from, next) {
            if (!auth.isLoggedIn()) {
                next('/login')
            } else {
                next()
            }
        }
    }, 
    {
        path: '/register',
        name: 'Register', 
        component: () => import('./views/authentication/Register.vue') 
    }, 
    {
        path: '/login',
        name: 'Login', 
        component: () => import('./views/authentication/Login.vue'), 
        beforeEnter(to, from, next) {
            if (!auth.isLoggedIn()) {
                next()
            } else {
                next('/home')
            }
        }
    }, 
    {
        path: '/reset-password',
        name: 'ResetPassword', 
        component: () => import('./views/authentication/ResetPassword.vue') 
    }, 
    

]

const router = new Router({
    mode: 'history',
    routes: routes, 
    linkExactActiveClass: 'active'
})

export default router; 