<template>
     <div class="container-fluid">
        <h1 class="mt-4">Dashboard</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>


        <div class="card mb-4">
            <div class="card-header d-flex">
							<span>
							<i class="fas fa-table mr-1"></i>Test View
							</span>

							<button class="btn btn-primary btn-sm ml-auto" @click="showTestModal">
								<span class="fa fa-plus"></span>	Create
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

				<b-modal ref="myTestModal" hide-footer title="Add New Test">
					<div class="d-block">
						<form > 
							<div class="form-group">
								<label for="name">Email address</label>
								<input 
									v-model="test.name"
									type="text" class="form-control" id="name" placeholder="Enter name here"
								>
							</div>
							<div class="form-group">
								<label for="image">Choose an image</label>
								<input 
									type="file" class="form-control" id="image" 
									@change="attachImage"
								>
							</div>
						</form>


					</div>
					<button type="button" class="btn btn-default" @click="hideTestModal">Cancel</button>
					<button type="button" @click="createNewTest" class="btn btn-primary">
						<span class="fa fa-check"></span>	Save
					</button>
				</b-modal>

    </div>
</template>

<script>
import * as testService from '../services/test_service'
export default {
		name: 'TestView', 
		data() {
			return {
				test: {
					name: '', 
					image: ''
				}
			}
		}, 
		methods: {
			hideTestModal() {
				this.$refs.myTestModal.hide()
			},
			showTestModal() {
				this.$refs.myTestModal.show()
			},  
			attachImage(event) {
				if (event.target.files.length > 0) {
					this.test.image = event.target.files[0]
				}

			}, 
			createNewTest: async function() {
				let formData = new FormData()
				formData.append('name', this.test.name)
				formData.append('image', this.test.image)
				console.log('form submit works')

				try {
					const response = await testService.createTest(formData)
					console.log('Test.vue response === ', response)
				} catch (error) {
					console.log('Test.vue error : ', error)
				}

			}
		}
}
</script>