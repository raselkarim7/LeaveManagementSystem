<template>
  <div class="container-fluid">
    <h1 class="mt-4">Apply Leave</h1>
    <!-- <ol class="breadcrumb mb-4">
      <li class="breadcrumb-item active">Employees</li>
    </ol> -->

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
              <th scope="col">#</th>
              <th scope="col">First</th>
              <th scope="col">Last</th>
              <th scope="col">Handle</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th scope="row">1</th>
              <td>Mark</td>
              <td>Otto</td>
              <td>@mdo</td>
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
//import * as testService from '../services/test_service'
import * as authService from "../../services/auth_service";
import { mapGetters } from 'vuex';
export default {
  name: "ApplyLeave",
  data() {
    return {
      test: {
        name: "",
        image: ""
      }
    };
  },
  computed: {
      ...mapGetters([
          'loggedInUser',
      ])
  },
  mounted() {
      console.log('AL ====== mounted: ', this.loggedInUser)
  }, 
  created() {
      console.log('AL ====== created: ', this.loggedInUser)
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
    hideTestModal() {
      this.$refs.myTestModal.hide();
    },
    showTestModal() {
      this.$refs.myTestModal.show();
    },

    createNewRecord: async function() {
      let formData = new FormData();
      formData.append("name", this.test.name);
      formData.append("image", this.test.image);
      console.log("form submit works");

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
