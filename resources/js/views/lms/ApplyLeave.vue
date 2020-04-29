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

        <button class="btn btn-primary btn-sm ml-auto" @click="showTestModal">
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

    <b-modal ref="myTestModal" hide-footer title="Add New Employee">
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
          </div>
          <div>
            <label for="startDate">Choose Start Date</label>
            <input type="date" id="startDate" v-model="leave.start_date" name="startDate">
            <p>Value: '{{ leave.start_date }}'</p>
          </div>
          <div>
            <label for="endDate">Choose End Date</label>
            <input type="date" id="endDate" v-model="leave.end_date" name="endDate">
            <p>Value: '{{ leave.end_date }}'</p>
          </div>
        </form>
      </div>
      <button type="button" class="btn btn-default" @click="hideTestModal">Cancel</button>
      <button type="button" @click="createNewRecord" class="btn btn-primary">
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
      user: {},
      leave_types: [],
      leave: {
        leave_types_id: "",
        no_of_days: "",
        start_date: "",
        end_date: ""
      },
      errors: {},
      
    };
  },
  computed: {
    ...mapGetters([])
  },
  mounted() {
    console.log("ApplyLeave ====== mounted: ");
  },
  created() {
    console.log("ApplyLeave ====== created: ");
    this.fetchLoggedInUser();
    this.fetchLeaveTypes();
  },

  methods: {
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

    hideTestModal() {
      this.$refs.myTestModal.hide();
    },
    showTestModal() {
      this.$refs.myTestModal.show();
    },

    createNewRecord: async function() {
        try {
            const response = await leaveService.addLeave(this.leave)
        } catch (error) {
            
        }

    }
  }
};
</script>
