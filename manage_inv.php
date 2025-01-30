<?php 
include 'db_connect.php'; 
if(isset($_GET['id'])){
	$qry = $conn->query("SELECT * FROM inventory where id=".$_GET['id']);
	foreach($qry->fetch_assoc() as $k => $v){
		$$k = $v;
	}
}

?>
<div class="container-fluid">
	<form action="" id="manage-inv">
		<input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : '' ?>">
		<div class="form-group">
			<div class="form-group">	
				<label for="suppID" class="control-label">Supply Name</label>
				<select id="suppID" class="custom-select browser-default" name="supply_id">
					<?php 
						$supply = $conn->query("SELECT * FROM supply_list order by name asc");
						while($row= $supply->fetch_assoc()):
					?>
					<option value="<?php echo $row['id'] ?>" <?php echo isset($supply_id) && $supply_id == $row['id'] ? "selected" : '' ?>><?php echo $row['name'] ?></option>
					<?php endwhile; ?>
				</select>
			</div>
			<div class="form-group">	
				<label for="quantity" class="control-label">Quantity</label>
				<input type="number" step="any" min="1" value="<?php echo isset($qty) ? $qty : 1 ?>" class="form-control text-right" name="qty" id="quantity">
			</div>
			<div class="form-group">	
				<label for="type" class="control-label">Type</label>
				<select name="stock_type" id="type" class="custom-select browser-default">
					<option value="1" <?php echo isset($stock_type) && $stock_type == 1 ? "selected" : '' ?>>Stock In</option>
					<option value="2" <?php echo isset($stock_type) && $stock_type == 2 ? "selected" : '' ?>>Use</option>
				</select>
			</div>
			<div class="form-group row justify-content-between align-items-center">
				<div class="col-6">
					<input type="submit" value="Save" class="btn btn-primary btn-block" id='submit'>
				</div>
				<div class="col-6">
					<button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">Cancel</button>
				</div>
        	
			</div>
		</div>
	</form>
</div>

<script>
	$('#manage-inv').submit(function(e){
		e.preventDefault()
		start_load()
		$.ajax({
			url:'ajax.php?action=save_inv',
			method:'POST',
			data:$(this).serialize(),
			success:function(resp){
				console.log(resp)
				if(resp == 1){
					alert_toast("Data successfully saved",'success')
					location.reload()
				}
			}
		})

	})
</script>