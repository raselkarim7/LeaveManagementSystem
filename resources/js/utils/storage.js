const TOKEN_KEY = 'leave-management-system-token'
const USER_KEY = 'leave-management-system-user'
const ROLES_KEY = 'leave-management-system-roles'

export default {
    token: {
        getToken () {
            return localStorage.getItem(TOKEN_KEY)
        }, 

        setToken(value) {
            return localStorage.setItem(TOKEN_KEY, value)
        }, 

        removeToken() {
            return localStorage.removeItem(TOKEN_KEY)
        }
    }, 

    user: {
        getUser () {
            return JSON.parse( localStorage.getItem(USER_KEY) )
        }, 

        setUser(value) {
            return localStorage.setItem(USER_KEY, JSON.stringify(value))
        }, 

        removeUser() {
            return localStorage.removeItem(USER_KEY)
        }
    }, 

    roles: {
        getRoles () {
            return JSON.parse( localStorage.getItem(ROLES_KEY) )
        }, 

        setRoles(value) {
            return localStorage.setItem(ROLES_KEY, JSON.stringify( value.map(o => o.name)) )
        }, 

        removeRoles() {
            return localStorage.removeItem(ROLES_KEY)
        }
    }
}