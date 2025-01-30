<?php include('db_connect.php');

if(isset($_GET['id'])){
	$qry = $conn->query("SELECT * FROM washing_list where id =".$_GET['id']);
	foreach($qry->fetch_array() as $k => $v){
		$$k = $v;
	}

}


?>
<br> <br>
<div class="container-fluid">
	
	<div class="col-lg-12">
		<div class="row">
			<!-- FORM Panel -->
			<div class="col-md-4">
			<form action="" id="manage-supply">
				<div class="card">
					<div class="card-header">
						    Washing Machine Form
				  	</div>
					<div class="card-body">
							<input type="hidden" name="id">
							<div class="form-group">
								<label class="control-label">Washing Machine</label>
								<textarea name="name" id="" cols="30" rows="2" class="form-control"></textarea>
							</div>
					</div>

                <div class="col-md-6">
					<div class="form-group">
						<label for="" class="control-label">Status</label>
						<select name="status" id="" class="custom-select browser-default">
							<option selected diasbled hidden>--Select Status--</option>
							<option>Active</option>
							<option>In Used</option>
							<option>Unavailable</option>
						</select>
					</div>
				</div>
                	
					<div class="card-footer">
						<div class="row">
							<div class="col-md-12">
								<button class="btn btn-sm btn-primary col-sm-3 offset-md-3"> Save</button>
								<button class="btn btn-sm btn-default col-sm-3" type="button" onclick="$('#manage-supply').get(0).reset()"> Cancel</button>
							</div>
						</div>
					</div>
				</div>
			</form>
			</div>
			<!-- FORM Panel -->

			<!-- Table Panel -->
			<div class="col-md-8">
				<div class="card">
					<div class="card-body">
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="text-center">Name</th>
									<th class="text-center">Status</th>
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$i = 1;
								$cats = $conn->query("SELECT * FROM washing_list order by id asc");
								while($row=$cats->fetch_assoc()):
								?>
								<tr>
									<td class="text-center"><?php echo $i++ ?></td>
									<td class="">
										<p><b><?php echo $row['name'] ?></b></p>
									</td>
									<td class="">
										<p><b><center><?php echo $row['status'] ?></center></b></p>
									</td>
									<td class="text-center">
										<button class="btn btn-sm btn-primary edit_machine" type="button" data-id="<?php echo $row['id'] ?>" data-name="<?php echo $row['name'] ?>"data-status="<?php echo $row['status'] ?>" >Edit</button>
										<button class="btn btn-sm btn-danger delete_machine" type="button" data-id="<?php echo $row['id'] ?>">Delete</button>
									</td>
								</tr>
								<?php endwhile; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<!-- Table Panel -->
		</div>
	</div>	

</div>
<style>
	
	td{
		vertical-align: middle !important;
	}
	td p{
		margin: unset
	}
</style>
<script>
	
	$('#manage-supply').submit(function(e){
		e.preventDefault()
		start_load()
		$.ajax({
			url:'ajax.php?action=save_machine',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully added",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
				else if(resp==2){
					alert_toast("Data successfully updated",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	})
	$('.edit_machine').click(function(){
		start_load()
		var cat = $('#manage-supply')
		cat.get(0).reset()
		cat.find("[name='id']").val($(this).attr('data-id'))
		cat.find("[name='name']").val($(this).attr('data-name'))
        cat.find("[name='status']").val($(this).attr('data-status'))
		end_load()
	})
	$('.delete_machine').click(function(){
		_conf("Are you sure to delete this supply?","delete_machine",[$(this).attr('data-id')])
	})
	function delete_machine($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_machine',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}
</script>