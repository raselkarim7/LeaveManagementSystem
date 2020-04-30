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

export function appliedLeaves() {
    return http({
        method: 'get', 
        url: 'applied-leaves',
    })
}

export function pendingApplications() {
    return http({
        method: 'get', 
        url: 'pending-applications',
    })
}
