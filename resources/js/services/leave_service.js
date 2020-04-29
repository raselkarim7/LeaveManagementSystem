import  http   from './http_service';

export function leaveTypes() {
    return http({
        method: 'get', 
        url: 'leave-types', 
    })
}

export function addLeave(data) {
    return http({
        method: 'post', 
        url: 'add-leave', 
        data: data
    })
}