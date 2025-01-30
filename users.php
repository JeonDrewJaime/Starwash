<?php 

?>

<div class="container-fluid">
<br>
	<div class="row">
	<div class="col-lg-12">
			<button class="btn btn-primary float-right btn-sm" id="new_user"><i class="fa fa-plus"></i> Add New User</button>
	</div>
	</div>
	<br>
	<div class="row">
		<div class="card col-lg-12">
			<div class="card-body">
			<table class="table-striped table-bordered col-md-12">
				<thead>
					<tr>
						<th class="text-center">No.</th>
						<th class="text-center">First Name</th>
						<th class="text-center">Last Name</th>
						<th class="text-center">Contact Number</th>
						<th class="text-center">Address</th>
						<th class="text-center">Email</th> <!-- Added email column -->
						<th class="text-center">Username</th>
						<th class="text-center">Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php
						include 'db_connect.php';
						$users = $conn->query("SELECT * FROM users order by name asc");
						$i = 1;
						while($row = $users->fetch_assoc()):
					?>
					<tr>
						<td>
							<?php echo $i++ ?>
						</td>
						<td>
							<?php echo $row['first_name'] ?>
						</td>
						<td>
							<?php echo $row['last_name'] ?>
						</td>
						<td>
							<?php echo $row['user_contact'] ?>
						</td>
						<td>
							<?php echo $row['user_address'] ?>
						</td>
						<td>
							<?php echo $row['email'] ?> <!-- Displaying email -->
						</td>
						<td>
							<center>
							<div class="btn-group">
								<div class="row justify-content-between align-items-center">
									<div class="col-6">
										<a class="edit_user btn btn-info" href="javascript:void(0)" data-id = '<?php echo $row['id']; ?>'>Edit</a>
									</div>
									<div class="col-6">
										<a class="delete_user btn btn-danger" href="javascript:void(0)" data-id = '<?php echo $row['id']; ?>'>Delete</a>
									</div>
								</div>
							</div>
							</center>
						</td>
					</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
			</div>
		</div>
	</div>

</div>

<script>
	
$('#new_user').click(function(){
	uni_modal('New User','manage_user.php')
	$("#uni_modal .modal-footer").hide();
})
$('.edit_user').click(function(){
	uni_modal('Edit User','manage_user.php?id='+$(this).attr('data-id'))
	$("#uni_modal .modal-footer").hide();
})
$('.delete_user').click(function(){
		// _conf("Are you sure to delete this user?","delete_user",[$(this).attr('data-id')])
	if (confirm('Are you sure you want to delete this user?')) {
		$.ajax({
			url:'ajax.php?action=delete_user',
			method:'POST',
			data:{ id: $(this).attr('data-id') } ,
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully deleted! ",'success')
					location.reload()
				}
			}
		})
	}
})
function delete_user($id){
		// start_load()
		$.ajax({
			url:'ajax.php?action=delete_user',
			method:'POST',
			data:{ id:$id } ,
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully deleted",'success')
				}
			}
		})
	}
</script>
