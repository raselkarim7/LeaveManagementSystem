import  http   from './http_service';

import axios from 'axios';
import storage from '../utils/storage'

export function login(data) {
    return new Promise((resolve, reject) => {
        http({
            method: 'post', 
            url: 'auth/login', 
            data: data
        }).then(response => {
            // console.log('response..... ', response)
            const { token_type, access_token } = response.data
            const AUTH_TOKEN = `${token_type} ${access_token}`; 

            axios.defaults.headers.common['Authorization'] = AUTH_TOKEN
            storage.token.setToken( AUTH_TOKEN )
            resolve(AUTH_TOKEN); 
        }).catch(error => {
            reject(error)
        })
       }); 
    
}

export function getUser() {
    return new Promise((resolve, reject) => {
        http({
            method: 'get', 
            url: 'auth/user'
        }).then(res => {
            const {id, name, email} = res.data; 
            const user = {id, name, email}
            const roles = res.data.roles 
            storage.user.setUser(user)
            storage.roles.setRoles(roles)

            resolve(res)
        }).catch(error => {
            reject(error)
        })


    })
    
    
}


export function isLoggedIn() {
    return storage.token.getToken() !== null; 
}

export function logout() {
    return http({
        method: 'get', 
        url: '/auth/logout'
    })
}