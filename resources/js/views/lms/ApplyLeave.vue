<template>
  <div class="container-fluid">
    <h1 class="mt-4">Apply Leave</h1>
    <!-- <ol class="breadcrumb mb-4">
      <li class="breadcrumb-item active">Employees</li>
    </ol>-->

    <div class="card mb-4">
      <div class="card-header d-flex">
        <span>
          <i class="fas fa-table mr-1"></i>Leaves & Info
        </span>

        <button class="btn btn-primary btn-sm ml-auto" @click="showFormModal">
          <span class="fa fa-plus"></span> Apply
        </button>
      </div>
      <div class="card-body">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">Name</th>
              <th scope="col">Email</th>
              <th scope="col">Roles</th>
              <th scope="col">Assigned HR Managers</th>
              <th scope="col">Total Paid Leave</th>
              <th scope="col">Paid Leave Taken</th>
              <th scope="col">Total Sick Leave</th>
              <th scope="col">Sick Leave Taken</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>{{user.name}}</td>
              <td>{{user.email}}</td>
              <td>
                <span
                  class="badge badge-primary m-1"
                  v-for="(role, index) in user.roles"
                  :key="index"
                >{{role.label}}</span>
              </td>
              <td>
                <span
                  class="badge badge-secondary m-1"
                  v-for="(manager, index) in user.managers"
                  :key="index"
                >{{manager.name}}</span>
              </td>
              <td>{{user.total_paid_leave}}</td>
              <td>{{user.paid_leave_taken}}</td>
              <td>{{user.total_sick_leave}}</td>
              <td>{{user.sick_leave_taken}}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <div class="card mb-4">
      <div class="card-header d-flex">
        <span>
          <i class="fas fa-table mr-1"></i>Leave Applications
        </span>

        <!-- <button class="btn btn-primary btn-sm ml-auto" @click="showFormModal">
          <span class="fa fa-plus"></span> Apply
        </button> -->
      </div>
      <div class="card-body">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">No of days</th>
              <th scope="col">Start Date</th>
              <th scope="col">End Date</th>
              <th scope="col">Leave Type</th>
              <th scope="col">Status</th>
              <th scope="col">Action</th>
              
            </tr>
          </thead>
          <tbody>
            <tr v-for="(appLeave, index) in applied_leaves" :key="index">
              <td>{{appLeave.no_of_days}}</td>
              <td>{{appLeave.start_date}}</td>
              <td>{{appLeave.end_date}}</td>
              <td>{{appLeave.leave_type.name}}</td>
              <td>
                <span class="m-1" :class="leaveStatusClass(appLeave.status)">{{appLeave.status}}</span>                              
              </td>
              <td> 
                  <button class="btn btn-warning btn-sm">Edit--To Work</button>
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
            <label for="role">Select Leave Types</label>
            <select class="form-control" id="role" v-model="leave.leave_types_id">
              <option disabled value>Please Select one</option>
              <option v-for="lt in leave_types" :key="lt.id" :value="lt.id">{{lt.name}}</option>
            </select>
            <div
              class="d-block invalid-feedback"
              v-if="errors.leave_types_id"
            >{{errors.leave_types_id[0]}}</div>
          </div>
          <div class="form-group">
            <label for="name">No of days</label>
            <input
              v-model="leave.no_of_days"
              type="number"
              class="form-control"
              id="name"
              placeholder="Enter no of days here"
            />
            <div class="d-block invalid-feedback" v-if="errors.no_of_days">{{errors.no_of_days[0]}}</div>
          </div>
          <div>
            <label for="startDate">Choose Start Date</label>
            <input type="date" id="startDate" v-model="leave.start_date" name="startDate" />
            <!-- <p>Value: '{{ leave.start_date }}'</p> -->
            <div class="d-block invalid-feedback" v-if="errors.start_date">{{errors.start_date[0]}}</div>

          </div>
          <div>
            <label for="endDate">Choose End Date</label>
            <input type="date" id="endDate" v-model="leave.end_date" name="endDate" />
            <!-- <p>Value: '{{ leave.end_date }}'</p> -->
            <div class="d-block invalid-feedback" v-if="errors.end_date">{{errors.end_date[0]}}</div>

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
import * as leaveService from "../../services/leave_service";
import * as authService from "../../services/auth_service";
import { mapGetters } from "vuex";
export default {
  name: "ApplyLeave",
  data() {
    return {
      submitingToServer: false,  
      user: {},
      leave_types: [],
      leave: {
        leave_types_id: "",
        no_of_days: "",
        start_date: "",
        end_date: ""
      },
      errors: {},
      applied_leaves: []
    };
  },
  computed: {
    ...mapGetters([])
  },
  mounted() {
    console.log("ApplyLeave ====== mounted: ")
  },
  created() {
    console.log("ApplyLeave ====== created: ")
    this.fetchLoggedInUser()
    this.fetchLeaveTypes()
    this.fetchAppliedLeaves()
  },

  computed: {

  },

  methods: {
    leaveStatusClass: param => {
        let design = ''; 
        if (param === 'pending') {
            design = 'primary'
        } else if  (param === 'approved') {
            design = 'success'
        } else if (param === 'approved') {
            design = 'danger'
        }
        return  `badge badge-pill badge-${design}`
    },   
    fetchLeaveTypes: async function() {
      try {
        const response = await leaveService.leaveTypes();
        this.leave_types = response.data;
      } catch (error) {}
    },
    fetchLoggedInUser: async function() {
      try {
        const response = await authService.getUser();
        this.user = response.data;
      } catch (error) {}
    },
    fetchAppliedLeaves: async function() {
        try {
            const response = await leaveService.appliedLeaves()   
            this.applied_leaves = response.data         
        } catch (error) {
            
        }
    },

    hideFormModal() {
        this.$refs.myFormModal.hide();
    },
    showFormModal() {
        this.leave = {
            leave_types_id: "",
            no_of_days: "",
            start_date: "",
            end_date: ""
        },
        this.$refs.myFormModal.show();
    },

    createNewRecord: async function() {
      this.submitingToServer = true;  
      try {
        const response = await leaveService.addLeave(this.leave);
        this.errors = {} 
        this.submitingToServer = false;  
        this.flashMessage.success({
            message: `Leave Applied successfully`,
            time: 2000
        });	
        this.fetchLoggedInUser();	
        this.fetchAppliedLeaves();
        this.hideFormModal()
      } catch (error) {
		this.submitingToServer = false;  
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
