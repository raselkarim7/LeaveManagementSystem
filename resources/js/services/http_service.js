import axios from 'axios'
import store from '../store/store.js'

export function http() {
    return axios.create({
        baseURL: store.state.apiURL, 
        headers: {
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