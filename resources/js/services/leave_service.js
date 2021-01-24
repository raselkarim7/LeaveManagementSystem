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
        url: 'leaves', 
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

export function approvedOrRejectedApplications() {
    return http({
        method: 'get', 
        url: 'approved-or-rejected-applications',
    })
}

export function leaveApproval(data) {
    return http({
        method: 'post', 
        url: 'leave-approval',
        data: data
    })
}