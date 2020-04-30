<template>
  <div class="container-fluid">
    <h1 class="mt-4">Employees</h1>
    <!-- <ol class="breadcrumb mb-4">
      <li class="breadcrumb-item active">Employees</li>
    </ol>-->

    <div class="card mb-4">
      <div class="card-header d-flex">
        <span>
          <i class="fas fa-table mr-1"></i>All Employees
        </span>

        <button class="btn btn-primary btn-sm ml-auto" @click="showTestModal">
          <span class="fa fa-plus"></span> Create Employee
        </button>
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
            <tr v-for="(obj, index) in pending_applications" :key="index">
              <td>{{obj.no_of_days}}</td>
              <td>{{obj.start_date}}</td>
              <td>{{obj.end_date}}</td>
              <td>{{obj.leave_type.name}}</td>
              <td>
                <span class="m-1" :class="leaveStatusClass(obj.status)">{{obj.status}}</span>
              </td>
              <td>
                <span
                  @click="handleAction(obj, 'approve')"
                  title="Approve"
                  class="btn btn-success btn-sm mr-2"
                >
                  <i class="fa fa-check"></i>
                </span>
                <span
                  @click="handleAction(obj, 'reject')"
                  title="Reject"
                  class="btn btn-danger btn-sm"
                >
                  <i class="fa fa-times"></i>
                </span>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <b-modal ref="myTestModal" hide-footer title="Add New Employee">
      <div class="d-block">
        <form>
          <div class="form-group">
            <label for="name">Name</label>
            <input
              v-model="test.name"
              type="text"
              class="form-control"
              id="name"
              placeholder="Enter name here"
            />
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

export default {
  name: "ApproveLeave",
  data() {
    return {
      pending_applications: [],

      test: {
        name: "",
        image: ""
      }
    };
  },
  created() {
    this.fetchPendingApplications();
    authService
      .getUser()
      .then(res => {
        console.log("Test.vue =========== ", res);
      })
      .catch(err => {
        console.log("Test.vue errrrrrr ", err);
      });
  },
  methods: {
    fetchPendingApplications: async function() {
      try {
        const response = await leaveService.pendingApplications();
        this.pending_applications = response.data;
        console.log(
          "pendingApplications Response === ",
          response.data,
          this.pending_applications
        );
      } catch (error) {}
    },
    leaveStatusClass: param => {
      let design = "";
      if (param === "pending") {
        design = "secondary";
      } else if (param === "approved") {
        design = "success";
      } else if (param === "approved") {
        design = "danger";
      }
      return `badge badge-pill badge-${design}`;
    },
    handleAction(obj, action_type) {
      const paramObj = {...obj}
      paramObj.action_type = action_type;   
      this.$swal
        .fire({
          title: `${action_type === "approve" ? 'Approve' : 'Reject' } Leave?`,
          icon: "warning",
          showCancelButton: true,
          confirmButtonText: `Yes, ${action_type === "approve" ? 'Approve' : 'Reject' }!`,
          cancelButtonText: "No."
        })
        .then(async result => {
          if (result.value) {
              try {
                const response = await leaveService.leaveApproval(paramObj)
                this.$swal.fire(
                    action_type === "approve" ? "Approved!" : "Rejected!",
                    `Leave has been ${ action_type === "approve" ? "Approved" : "Rejected" } Successfully.`,
                    "success"
                );
                // console.log('Leave Approval resp >> ', response)
              } catch (error) {
                  
              }
          }
        });
    },

    hideTestModal() {
      this.$refs.myTestModal.hide();
    },
    showTestModal() {
      this.$refs.myTestModal.show();
    },

    createNewRecord: async function() {
      //   let formData = new FormData();
      //   formData.append("name", this.test.name);
      //   formData.append("image", this.test.image);
      //   console.log("form submit works");
      // try {
      // 	const response = await testService.createTest(formData)
      // 	console.log('Test.vue response === ', response)
      // } catch (error) {
      // 	console.log('Test.vue error : ', error)
      // }
    }
  }
};
</script>
