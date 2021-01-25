<template>
  <div class="container-fluid">
    <h1 class="mt-4">Subordinate Employees Applications </h1>
    <!-- <ol class="breadcrumb mb-4">
      <li class="breadcrumb-item active">Employees</li>
    </ol>-->

    <div class="card mb-4">
      <div class="card-header d-flex">
        <span>
          <i class="fas fa-table mr-1"></i>Pending Applications
        </span>

      </div>
      <div class="card-body">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">Applied By</th>
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
              <td>
                <div class="handIcon text-primary" @click="showUser(obj.applied_user)">  <b> <u> {{obj.applied_user.name }} </u> </b>   </div>
              </td>  
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
                  class="btn btn-success btn-sm m-1"
                >
                  <i class="fa fa-check"></i>
                </span>
                <span
                  @click="handleAction(obj, 'reject')"
                  title="Reject"
                  class="btn btn-danger btn-sm m-1"
                >
                  <i class="fa fa-times"></i>
                </span>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <div class="card mb-4">
      <div class="card-header d-flex">
        <span>
          <i class="fas fa-table mr-1"></i>Approved / Rejected Applications
        </span>

      </div>
      <div class="card-body">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">Applied By</th>
              <th scope="col">No of days</th>
              <th scope="col">Start Date</th>
              <th scope="col">End Date</th>
              <th scope="col">Leave Type</th>
              <th scope="col">Action By</th>
              <th scope="col">Status</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(obj, index) in approved_or_rejected_applications" :key="index">
              <td>
                <div class="handIcon text-primary"  @click="showUser(obj.applied_user)">   <b> <u >{{obj.applied_user.name }}</u> </b>  </div>
              </td>  
              <td>{{obj.no_of_days}}</td>
              <td>{{obj.start_date}}</td>
              <td>{{obj.end_date}}</td>
              <td> <b>{{obj.leave_type.name}}</b> </td>
              <td> <div class="handIcon text-primary" @click="showUser(obj.approved_user)">  <b> <u>{{obj.approved_user && obj.approved_user.name }}</u> </b> </div> </td>
              <td>
                <span class="m-1" :class="leaveStatusClass(obj.status)">{{obj.status}}</span>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>


    <b-modal ref="myTestModal" hide-footer title="Employee Data">

      <div class="d-block" >
        <div> <b>Name:</b> {{clickedUser.name }} </div>
        <div> <b>Email:</b> {{clickedUser.email }} </div>
        <div> <b>Roles:</b> <span class="m-1 badge badge-primary" v-for="(role,idx) in clickedUser.roles" :key="idx">{{role.label}} </span> </div>
        <hr>
        <div> <b>Total Paid Leave:</b> {{clickedUser.total_paid_leave }} </div>
        <div> <b>Paid Leave Taken:</b> {{clickedUser.paid_leave_taken }} </div>
        <hr>
        <div> <b>Total Sick Leave:</b> {{clickedUser.total_sick_leave }} </div>
        <div> <b>Sick Leave Taken:</b> {{clickedUser.sick_leave_taken }} </div>
      </div>
      <!-- <button type="button" class="btn btn-default" @click="hideTestModal">Cancel</button> -->
      <button type="button" @click="hideTestModal" class="mt-2 btn btn-primary">
        Cancel
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
      approved_or_rejected_applications: [], 
      clickedUser:{

      },   
      test: {
        name: "",
        image: ""
      }
    };
  },
  created() {
    this.fetchPendingApplications();
    this.fetchApprovedOrRejectedApplications();
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
    showUser(obj) {
        this.clickedUser = obj; 
        this.showTestModal(); 
    },
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
    fetchApprovedOrRejectedApplications: async function() {
      try {
        const response = await leaveService.approvedOrRejectedApplications();
        this.approved_or_rejected_applications = response.data;
        console.log(
          "approved_or_rejected_applications Response === ",
          response.data,
          this.approved_or_rejected_applications
        );
      } catch (error) {}
    }, 
    leaveStatusClass: param => {
      let design = "";
      if (param === "pending") {
        design = "secondary";
      } else if (param === "approved") {
        design = "success";
      } else if (param === "rejected") {
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
                ).then(() => {
                  this.fetchApprovedOrRejectedApplications();
                  this.fetchPendingApplications();
                });
                // console.log('Leave Approval resp >> ', response)
              } catch (error) {
                  this.flashMessage.error({
                    message: error.response.data.message,
                    time: 3000
                  });
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

<style> 
    .handIcon:hover {
        cursor: pointer;
    }
</style>