<template>
     <div class="container-fluid">
        <h1 class="mt-4">Dashboard</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
        <div class="row">
            <div class="col-xl-3 col-md-6">
                <div class="card bg-info text-white mb-4">
                    <div class="card-body">Logged In User Info</div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <ul> 
                            <li><b>Name:</b> {{user.name}} </li>
                            <li><b>Email:</b> {{user.email}} </li>
                            <li>
                                <b>Roles:</b> 
                                <span class="m-1 badge badge-secondary" 
                                v-for="role in user.roles" :key="role.id">{{role.label}}</span> 
                            </li>
                            <li><b>Total paid leave:</b> {{user.total_paid_leave}} </li>
                            <li><b>Paid leave taken:</b> {{user.paid_leave_taken}} </li>
                            <li><b>Total sick leave:</b> {{user.total_sick_leave}} </li>
                            <li><b>Sick leave taken:</b> {{user.sick_leave_taken}} </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card bg-success text-white mb-4">
                    <div class="card-body">Roles </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <div v-if="hasPermission(['admin', 'hr'])"> 
                            <ul>
                                <li v-for="role in roles" :key="role.id"> {{role.label}} </li>
                            </ul>
                        </div>
                        <div v-else> 
                            You have no permission to see. Only Adminstrators & Managers will see this.
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-secondary text-white mb-4">
                    <div class="card-body">HR Managers </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <div v-if="hasPermission(['admin', 'hr'])"> 
                            <ul>
                                <li v-for="obj in hr_managers" :key="obj.id"> {{obj.name}} </li>
                            </ul>
                        </div>
                        <div v-else>You have no permission to see. Only Adminstrators & Managers will see this.</div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card bg-primary text-white mb-4">
                    <div class="card-body">Total Employees</div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        {{ total_employeees }}
                    </div>
                </div>
            </div>

        </div>


    </div>
</template>

<script>
import * as employeeService from "../services/employee_service";
import * as authService from "../services/auth_service";
import { mapGetters } from 'vuex'
export default {
    name: 'Dashboard', 
    data() {
        return {
            total_employeees: '', 
            roles: [],
            hr_managers: [], 
            user: {
                roles: []
            }
        }
    }, 
    created() {
        this.fetchEmployeees()
        this.fetchRoles()
        this.fetchHRmanagers()
        this.getLoginUserInfo()
        
    },
    computed: {
        ...mapGetters([
            'hasPermission',
        ])
    },
    methods: {
        fetchEmployeees: async function() {
            try {
                const response = await employeeService.getEmployees();
                this.total_employeees = response.data.length; 
            } catch (error) {
                
            }
        }, 
        fetchRoles: async function() {
            try {
                const response = await employeeService.getRoles(); 
                this.roles = response.data; 
            } catch (error) {
                
            }
        }, 
        fetchHRmanagers: async function() {
            try {
                const response = await employeeService.getHRmanagers()
                this.hr_managers = response.data
            } catch (error) {
                
            }
        }, 
        getLoginUserInfo: async function() {
            try {
                const response = await authService.getUser()
                this.user = response.data
            } catch (error) {
                
            }
        }
    }
}
</script>