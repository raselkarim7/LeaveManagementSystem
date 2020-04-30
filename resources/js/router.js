import Vue from 'vue'
import Router from 'vue-router'
Vue.use(Router)

import store from './store/store.js'
import Dashboard from './views/Dashboard.vue'
import Test from './views/Test.vue'; 

import Employees from './views/lms/Employees.vue'
import ApplyLeave from './views/lms/ApplyLeave.vue'
import ApproveLeave from './views/lms/ApproveLeave'
import ChangePassword from './views/lms/ChangePassword'

import * as auth from './services/auth_service'; 

function checkRoutePermission(to) {
    const routeObj = to.matched[to.matched.length - 1];
    if (Object.prototype.hasOwnProperty.call(routeObj.meta, 'permission_name')) {
      return store.getters['hasPermission'](routeObj.meta.permission_name) ? true : false
    }
    return true;
  }
  

const routes = [
    {
        path: '', 
        redirect: '/home',
    }, 
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
                component: Test, 
                meta: {
                    permission_name: 'admin'
                },
          
            }, 
            {
                path: 'employees',
                name: 'Employees', 
                component: Employees, 
                meta: {
                    permission_name: ['admin', 'hr']
                },
          
            }, 
            {
                path: 'apply-leave',
                name: 'ApplyLeave', 
                component: ApplyLeave, 
                meta: {
                    permission_name: []
                },
          
            }, 
            {
                path: 'approve-leave',
                name: 'ApproveLeave', 
                component: ApproveLeave, 
                meta: {
                    permission_name: ['admin', 'hr']
                },            
            }, 
            {
                path: 'change-password',
                name: 'ChangePassword', 
                component: ChangePassword, 
                meta: {
                    permission_name: []
                },            
            }, 

            
            
            
        ], 
        beforeEnter(to, from, next) {
            if (!auth.isLoggedIn()) {
                next('/login')
            } else {
                if (checkRoutePermission(to)) {
                    next()
                } else {
                    next('/no-access')
                    return;
                }
            }
        }
    }, 
    {
        path: '/no-access',
        name: 'Noaccess', 
        component: () => import('./views/fallback/Noaccess.vue')  
    },
    // {
    //     path: '/register',
    //     name: 'Register', 
    //     component: () => import('./views/authentication/Register.vue') 
    // }, 
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
    // {
    //     path: '/reset-password',
    //     name: 'ResetPassword', 
    //     component: () => import('./views/authentication/ResetPassword.vue') 
    // }, 
    

]

const router = new Router({
    mode: 'history',
    routes: routes, 
    linkExactActiveClass: 'active'
})

export default router; 