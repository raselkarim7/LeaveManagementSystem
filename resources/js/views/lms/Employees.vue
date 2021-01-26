<template>
  <div class="container-fluid">
    <h1 class="mt-4">Employees</h1>
    <!-- <ol class="breadcrumb mb-4">
      <li class="breadcrumb-item active">Employees</li>
    </ol> -->

    <div class="card mb-4">
      <div class="card-header d-flex">
        <span>
          <i class="fas fa-table mr-1"></i>All Employees
        </span>

        <button class="btn btn-primary btn-sm ml-auto" @click="createEmployee">
          <span class="fa fa-plus"></span> Create Employee
        </button>
      </div>
      <div class="card-body">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Name</th>
              <th scope="col">Email</th>
							<th scope="col">Roles</th>
							<th scope="col">Assigned HR Managers</th>
							
              <th scope="col">Total Paid Leave</th>
              <th scope="col">Paid Leave Taken</th>
              <th scope="col">Total Sick Leave</th>
							<th scope="col">Sick Leave Taken</th>
							<th scope="col">Action</th>
							
            </tr>
          </thead>
          <tbody>
            <tr v-for="(emp, index) in allEmployees" :key="index">
              <th scope="row">{{index + 1}}</th>
              <td>{{emp.name}}</td>
              <td>{{emp.email}}</td>
							<td> 
								<span class="badge badge-primary m-1" v-for="(role, index) in emp.roles" :key="index">{{role.label}} </span>
							</td>
							<td> 
								<span class="badge badge-secondary m-1" v-for="(manager, index) in emp.managers" :key="index">{{manager.name}} </span>
							</td>
              <td>{{emp.total_paid_leave}}</td>
              <td>{{emp.paid_leave_taken}}</td>
		          <td>{{emp.total_sick_leave}}</td>
              <td>{{emp.sick_leave_taken}}</td>
							<td> 
								<button class="btn btn-warning btn-sm" @click="editEmployee(emp)">Edit</button>
							</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <b-modal ref="myFormModal" hide-footer title="Add New Employee">
      <div class="d-block">
        <form>
          <div class="form-group">
            <label for="name">Name</label>
            <input
              v-model="user.name"
              type="text"
              class="form-control"
              id="name"
              placeholder="Enter name here"
            />
            <div class="d-block invalid-feedback" v-if="errors.name">{{errors.name[0]}}</div>
          </div>
          <div class="form-group">
            <label for="name">Email</label>
            <input
              v-model="user.email"
              type="email"
              class="form-control"
              id="name"
              placeholder="Enter email here"
            />
            <div class="d-block invalid-feedback" v-if="errors.email">{{errors.email[0]}}</div>
          </div>
          <div class="form-group">
						<label for="role">Select Role</label>
						<select class="form-control" id="role" v-model="user.role_ids" multiple>
							<option disabled value="">Please Select one</option>
							<option v-for="role in roles" :key="role.id" :value="role.id"> {{role.label}}</option>
						</select>
            <div class="d-block invalid-feedback" v-if="errors.role_ids">{{errors.role_ids[0]}}</div>

					</div>

					<div class="form-group">
						<label for="role">Assign Manager</label>
						<select class="form-control" id="role" v-model="user.manager_ids" multiple>
							<option disabled value="">Please Select one</option>
							<option v-for="(obj,index) in hr_managers" :key="index" :value="obj.id"> {{obj.name}}</option>
						</select>
            <div class="d-block invalid-feedback" v-if="errors.manager_ids">{{errors.manager_ids[0]}}</div>
					</div>
					
          <div class="form-group">
            <label for="name">Total Paid Leave</label>
            <input
              v-model.number="user.total_paid_leave"
              type="number"
              class="form-control"
              id="name"
              placeholder="Enter Total Paid Leave"
            />
            <div class="d-block invalid-feedback" v-if="errors.total_paid_leave">{{errors.total_paid_leave[0]}}</div>
          </div>
          <div class="form-group">
            <label for="name">Total Sick Leave</label>
            <input
              v-model.number="user.total_sick_leave"
              type="number"
              class="form-control"
              id="name"
              placeholder="Enter Total Sick Leave"
            />
	          <div class="d-block invalid-feedback" v-if="errors.total_sick_leave">{{errors.total_sick_leave[0]}}</div>
          </div>
        </form>
      </div>
      <button type="button" class="btn btn-default" @click="hideFormModal">Cancel</button>
      <button type="button" :disabled="submitingToServer" @click="createNewRecord" class="btn btn-primary">
        <span class="fa fa-check"></span> Save
      </button>
    </b-modal>
  </div>
</template>

<script>

import * as employeeService from "../../services/employee_service";
import * as authService from "../../services/auth_service";

export default {
  name: "Employees",
  data() {
    return {
			operationMode: 'create', 
			roles: [],   
			hr_managers: [], 
			allEmployees: [], 
			submitingToServer: false, 
      user: {
        name: "",
				email: "", 
				role_ids: [],
				manager_ids: [], 
        total_paid_leave: '', 
        total_sick_leave: '', 
        
			}, 
			errors: {

			}
    };
  },
  created() {
		 this.fetchRoles() 
		 this.fetchHRmanagers()
		 this.fetchAllEmployees()
  },
  methods: {
		editEmployee(employee) {
			console.log('edit employee ---------> ', employee)
			const role_ids = employee.roles.map(o => o.id)
			const manager_ids = employee.managers.map(o => o.id)
			const {id, name, email, total_paid_leave, total_sick_leave } = employee;
			const obj =  {id, name, email, total_paid_leave, total_sick_leave, role_ids, manager_ids }
      this.user = obj;
      this.errors = {};
			this.showFormModal(); 
			this.operationMode = 'edit'
		}, 
		fetchAllEmployees: async function () {
			try {
				const response = await employeeService.getEmployees(); 
				this.allEmployees = response.data; 
			} catch (error) {
				
			}
		}, 
    fetchRoles: async function () {
        try {
            const response = await employeeService.getRoles(); 
            this.roles = response.data
        } catch (error) {
            
        }
		} ,  
		fetchHRmanagers: async function () {
			try {
            const response = await employeeService.getHRmanagers(); 
						// console.log('fetchHRmanagers: ', response)
						this.hr_managers = response.data; 
        } catch (error) {
            
        }
		}, 
    hideFormModal() {
      this.$refs.myFormModal.hide();
		},
		createEmployee() {
			this.user = {
        name: "",
				email: "", 
				role_ids: [],
				manager_ids: [], 
        total_paid_leave: '', 
        total_sick_leave: '', 
      }, 
      this.operationMode = 'create';
      this.errors = {};
			this.showFormModal(); 
		}, 

    showFormModal() {
      this.$refs.myFormModal.show();
    },

    createNewRecord: async function() {
			this.submitingToServer = true;
			try {

				if (this.operationMode === 'edit') {
					await employeeService.editEmployee(this.user)
				} else {
					await employeeService.addEmployee(this.user)
				}
				this.submitingToServer = false;
				this.errors = {}
				this.fetchAllEmployees() 
				this.flashMessage.success({
              message: `An employee ${this.operationMode === 'edit' ? 'Edited': 'Created' }  successfully`,
              time: 2000
						});		
				this.hideFormModal()

			} catch (error) {
				this.submitingToServer = false;
        // console.log("Login.vue Error ========= ", error, error.response);
        switch (error.response.status) {
          case 422:
            this.errors = error.response.data.errors;
            //console.log("errors =========== ", this.errors);
            break;

          case 500:
            this.flashMessage.error({
              message: error.response.data.message,
              time: 2000
            });
            break;

          default:
            break;
        }
			}

    }
  }
};
</script>