<template>
  <div class="container-fluid">

    <div class="ml-3 mt-5 "> 
        <button class="btn btn-primary btn-sm ml-auto" @click="showTestModal">
          <span class="fa fa-key"></span> Click Here To Change Password
        </button>
    </div>

    <b-modal ref="myTestModal" hide-footer title="Add New Employee">
      <div class="d-block">
        <form>
          <div class="form-group">
            <label for="old_password">Old Password</label>
            <input
              v-model="password.old_password"
              type="password"
              class="form-control"
              id="old_password"
              placeholder="Enter old password"
            />
            <div class="d-block invalid-feedback" v-if="errors.old_password">{{errors.old_password[0]}}</div>
          </div>
            <div class="form-group">
            <label for="password">New Password</label>
            <input
              v-model="password.password"
              type="password"
              class="form-control"
              id="password"
              placeholder="Enter new password"
            />
            <div class="d-block invalid-feedback" v-if="errors.password">{{errors.password[0]}}</div>
          </div>
          <div class="form-group">
            <label for="password_confirmation">Confirm password</label>
            <input
              v-model="password.password_confirmation"
              type="password"
              class="form-control"
              id="password_confirmation"
              placeholder="Enter Confirm password"
            />
            <div class="d-block invalid-feedback" v-if="errors.password_confirmation">{{errors.password_confirmation[0]}}</div>
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
//import * as testService from '../services/test_service'
import * as authService from "../../services/auth_service";

export default {
  name: "ChangePassword",
  data() {
    return {
			submitingToServer: true, 
      password: {
        old_password: "",
        password: "", 
        password_confirmation: "" 
			},
			errors: {}
    };
  },
  created() {
    
  },
  methods: {
    hideTestModal() {
      this.$refs.myTestModal.hide();
    },
    showTestModal() {
			this.password = {
        old_password: "",
        password: "", 
        password_confirmation: "" 
			}
      this.$refs.myTestModal.show();
    },

    createNewRecord: async function() {
				this.submitingToServer = true; 
        try {
						const response = await authService.changePassword(this.password)
						this.submitingToServer = false; 
						this.flashMessage.success({
									message: `Password Changed successfully`,
									time: 2000
								});		
						this.hideTestModal()


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
