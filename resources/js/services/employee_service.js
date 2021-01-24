import  http   from './http_service';

export function getRoles() {
    return http({
            method: 'get', 
            url: 'roles', 
        })
}

export function getEmployees() {
    return http({
        method: 'get', 
        url: 'employees', 
    })
}

export function getEmployeesLength() {
    return http({
        method: 'get', 
        url: 'employees-count', 
    })
}

export function getHRmanagers() {
    return http({
        method: 'get', 
        url: 'hrmanagers', 
    })
}

export function addEmployee(data) {
    return http({
        method: 'post', 
        url: '/employee', 
        data: data
    })
}

export function editEmployee(data) {
    return http({
        method: 'put', 
        url: '/employee', 
        data: data
    })
}


