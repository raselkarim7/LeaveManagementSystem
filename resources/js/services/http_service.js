import axios from 'axios'
import store from '../store/store.js'
import storage from '../utils/storage'
import router from '../router'

import VueApp from '../app.js';


const service = axios.create({
		baseURL: store.state.apiURL, 
})

service.interceptors.request.use(
		config => {
				config.headers['Authorization'] =  storage.token.getToken() 
				config.headers['Accept'] = 'application/json'
				config.headers['Content-Type'] = 'application/json'
			return config
		},
		error => {
			// Do something with request error
			console.log(error) // for debug
			return Promise.reject(error)
		}
	)

	service.interceptors.response.use(
		response => response,
		error => {
				console.log('http_service.js, err----->' , error.response) // for debug
				if (error.response.status !== 422) {
					if (error.response.status === 401 && router.currentRoute.path === '/login') {
						VueApp.flashMessage.error({
							message: 'Invalid Email Or Password',
							time: 3000
						});
					} else {
						VueApp.flashMessage.error({
							message: error.response.data.message,
							time: 3000
						});
					}
				}  

				if (error.response.status === 401 && router.currentRoute.path !== '/login') {                
						storage.token.removeToken(); 
						storage.user.removeUser(); 
						storage.roles.removeRoles(); 

						router.push('/login')
				}
				return Promise.reject(error)
			}
	)

export default service;

