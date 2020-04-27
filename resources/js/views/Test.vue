<template>
     <div class="container-fluid">
        <h1 class="mt-4">Dashboard</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>


        <div class="card mb-4">
            <div class="card-header"><i class="fas fa-table mr-1"></i>Test View</div>
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
    </div>
</template>

<script>
export default {
    name: 'TestView'
}
</script>