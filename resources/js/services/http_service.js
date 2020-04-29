import axios from 'axios'
import store from '../store/store.js'
import storage from '../utils/storage'

export function http() {
    return axios.create({
        baseURL: store.state.apiURL, 
        headers: {
            Authorization: storage.token.getToken(), 
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
}

export function httpFile() {
    return axios.create({
        baseURL: store.state.apiURL, 
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'multipart/form-data'
        }
    })
}