<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-5">
        <div class="card shadow-lg border-0 rounded-lg mt-5">
          <div class="card-header">
            <h3 class="text-center font-weight-light my-4">Login</h3>
          </div>
          <div class="card-body">
            <form>
              <div class="form-group">
                <label class="small mb-1" for="email">Email</label>
                <input
                  v-model="user.email"
                  class="form-control py-4"
                  id="email"
                  type="email"
                  placeholder="Enter email address"
                />
                <div class="d-block invalid-feedback" v-if="errors.email">{{errors.email[0]}}</div>
              </div>
              <div class="form-group">
                <label class="small mb-1" for="password">Password</label>
                <input
                  v-model="user.password"
                  class="form-control py-4"
                  id="password"
                  type="password"
                  placeholder="Enter password"
                />
                <div
                  class="d-block invalid-feedback"
                  v-if="errors.password"
                >{{ errors.password[0] }}</div>
              </div>
              <div class="form-group">
                <div class="custom-control custom-checkbox">
                  <input
                    v-model="user.remember_me"
                    class="custom-control-input"
                    id="rememberPasswordCheck"
                    type="checkbox"
                  />
                  <label class="custom-control-label" for="rememberPasswordCheck">Remember password</label>
                </div>
              </div>
              <div class="form-group d-flex align-items-left justify-content-between mt-4 mb-0">
                <router-link class="small" to="/reset-password">Forgot Password?</router-link>
                <button
                  @click="handleLogin"
                  :disabled="submitingToServer"
                  class="btn btn-primary"
                >Login</button>
              </div>
            </form>
          </div>
          <div class="card-footer text-center">
            <div class="small">
              <router-link to="/register">Need an account? Sign up!</router-link>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import * as authService from "../../services/auth_service";
export default {
  name: "Login",
  data() {
    return {
      submitingToServer: false,
      user: {
        email: "",
        password: "",
        remember_me: false
      },
      errors: {}
    };
  },
  mounted() {
    // console.log('Login.vue === mounted...')
    document.querySelector("body").style.backgroundColor = "#343a40";
  },
  destroyed() {
    // console.log('Login.vue === destroyed...')
    document.querySelector("body").style.backgroundColor = "transparent";
  },

  methods: {
    handleLogin: async function() {
      console.log("inside login....");
      this.submitingToServer = true;
      try {
        const response = await authService.login(this.user);
        this.submitingToServer = false;
        this.errors = {};
        this.$store.dispatch("setToken", response);

        await this.fethUserNow();
        
        this.$router.push('/home');

        console.log("Login.vue Response =========>>> ", response);
      } catch (error) {
        this.submitingToServer = false;
        console.log("Login.vue Error ========= ", error, error.response);
        switch (error.response.status) {
          case 422:
            this.errors = error.response.data.errors;
            console.log("errors =========== ", this.errors);
            break;

          case 401:
            this.flashMessage.error({
              message: error.response.data.message,
              time: 3000
            });
            break;

          case 500:
            this.flashMessage.error({
              message: error.response.data.message,
              time: 2000
            });
            break;

          default:
            this.flashMessage.error({
              message: "Some error occured, Please Try again",
              time: 3000
            });
            break;
        }
      }
    },

    fethUserNow: async function() {
      try {
        const response = await authService.getUser();
        console.log("user --------> ", response.data);
        this.$store.dispatch("setUser", response.data);
      } catch (error) {
        console.log("wwwwwwww ----------> ", error, error.response);
      }
    }
  }
};
</script>