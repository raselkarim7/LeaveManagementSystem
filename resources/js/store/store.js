import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

import storage from '../utils/storage'; 

export default new Vuex.Store({
    state: {
        apiURL: 'http://localhost:8000/api', 
        serverPath: 'http://localhost:8000',

        token: storage.token.getToken(), 
        user: {}, 
        roles: storage.roles.getRoles() || []

    },
    mutations: {
        SET_TOKEN: (state, token) => {
            state.token = token
          },

        SET_USER: (state, user) => {
            state.user = user
          },

        SET_ROLES: (state, roles) => {
            state.roles = roles
          },

    }, 
    actions: {

        setToken({ commit, state }, value) {
            commit('SET_TOKEN', value)
        },
        setUser({ commit, state }, value) {
            commit('SET_USER', value)
            const roles = value.roles.map(o => o.name);
            this.commit('SET_ROLES', roles) 

        },
        setRoles({ commit, state }, value) {
            commit('SET_ROLES', value)
        },

    },
    getters: { 
        hasPermission: state => (permission_name) => {
            /* parameter can be string of single or multiple for Array, EVEN '' or [] */
            if (Array.isArray(permission_name)) {
                if (permission_name.length === 0) {
                    return true; 
                }
              return permission_name.some(item => state.roles.includes(item));
            }
            if (typeof(permission_name) === 'string') {
                if(permission_name.length === 0 ) {
                    return true; 
                }
            }
            return state.roles.includes(permission_name)
          },
  
     }


})