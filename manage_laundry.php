<?php
include "db_connect.php";
if(isset($_GET['id'])){
	$qry = $conn->query("SELECT * FROM laundry_list where id =".$_GET['id']);
	foreach($qry->fetch_array() as $k => $v){
		$$k = $v;
	}
}

if(isset($_GET['id']))
{
	$ID = $_GET['id'];
	$savings = "UPDATE washing_list w JOIN laundry_list l on w.name = l.washing_id SET w.status = 'In Used' WHERE l.id = '$ID'";
	$savingss = $conn->query($savings) or die($conn->error);
	if($savingss)
	{
	$savings1 = "UPDATE washing_list w JOIN laundry_list l on w.name = l.washing_id SET w.status = 'Active' WHERE l.status = 3 and l.id = '$ID'";
	$savings2 = $conn->query($savings1) or die($conn->error);
	}
}


?>
<div class="container-fluid">
	<!-- Table Users -->
	<div class="table-existingusers">
	<label>Search</label>
	<input type="search" class="" placeholder="" aria-controls="table_id">
	<u class="fw-bold text-primary text-center mt-3 mb-3"><h5 class="fw-bold text-primary text-center mt-3 mb-3">PREVIOUS CUSTOMERS</h5></u>
		<table class="table-striped table-hover table-bordered col-md-12">
			<thead>
				<tr>
					<th class="text-center">#</th>
					<th class="text-center">First Name</th>
					<th class="text-center">Last Name</th>
					<th class="text-center">Contact Number</th>
					<th class="text-center">Address</th>
					<th class="text-center">Action</th>
				</tr>
			</thead>
			<tbody>
				<?php
					include 'db_connect.php';
					$users = $conn->query("SELECT * FROM laundry_list GROUP BY CONCAT(first_name, last_name) ORDER by id DESC");
					$i = 1;
					while($row= $users->fetch_assoc()):
				?>
				<tr>
					<td class="text-center">
						<?php echo $i++ ?>
					</td>
					<td class="text-center">
						<?php echo $row['first_name'] ?>
					</td>
					<td class="text-center">
						<?php echo $row['last_name'] ?>
					</td>
					<td class="text-center">
						<?php echo $row['contact'] ?>
					</td>
					<td class="text-center">
						<?php echo $row['customer_address'] ?>
					</td>
					<td class="text-center">
						<button class="btn btn-sm btn-primary btn-bind-user">Use</button>
					</td>
				</tr>
				<?php endwhile; ?>
			</tbody>
		</table>
	</div>
	<u class="fw-bold text-primary text-center mt-3 mb-3"><h5 class="fw-bold text-primary text-center mt-3 mb-3">PERSONAL INFORMATION</h5></u>
	<form id="manage-laundry" method="post">
		<div class="col-lg-12">	
			<input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : '' ?>">	
			<div class="row">
				<div class="col-md-6">	
					<div class="form-group">	
						<label for="fname" class="control-label">First Name</label>
						<input type="text" class="form-control" id="fname" name="first_name" value="<?php echo isset($first_name) ? $first_name : ''; ?>" required>
					</div>

					<!-- Last Name-->
					<div class="form-group">
					<label for="lname" class="control-label">Last Name</label>
					<input type="text" class="form-control" id="lname" name="last_name" value="<?php echo isset($last_name) ? $last_name : '' ?>" required>
					</div>

					  <!-- Email Address-->
					  <div class="form-group">
                    <label for="email" class="control-label">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo isset($email) ? $email : '' ?>" required>
                </div>
				</div>
					<?php if(isset($_GET['id'])): ?>
					<div class="col-md-6">
						<div class="form-group">
							<label for="status" class="control-label">Status</label>
							<select name="status" id="status" class="custom-select browser-default">
								<option value="0" <?php echo $status == 0 ? "selected" : '' ?>>Pending</option>
								<option value="1" <?php echo $status == 1 ? "selected" : '' ?>>Processing</option>
								<option value="2" <?php echo $status == 2 ? "selected" : '' ?>>Ready to be Claim</option>
								<option value="3" <?php echo $status == 3 ? "selected" : '' ?>>Claimed</option>
							</select>
						</div>
					</div>
					<?php endif; ?>				
					<!-- contact number -->
					<?php if(!isset($_GET['id'])): ?>
					<div class="col-md-6">	
						<div class="form-group">	
							<label for="contact" class="control-label">Contact Number</label>
							<input type="text" id="contact" class="form-control" maxlength="11" name="contact" required>					
					</div>
					<!-- Address -->
					<div class="form-group">
					<label for="address" class="control-label">Address</label>
					<input type="text" class="form-control" id="address" name="customer_address" value="<?php echo isset($customer_address) ? $customer_address : '' ?>" required>
					</div>
					</div>
					<?php endif; ?>



					<?php if(isset($_GET['id'])){
						$ID = $_GET['id'];
						$quee = "SELECT * FROM laundry_list where id = '$ID'";
						$contact = $conn->query($quee) or die($conn->error);
						$showContacts = $contact->fetch_assoc();
					?>

					<div class="col-md-6">	
						<div class="form-group">	
							<label for="contact" class="control-label">Contact Number</label>
							<input type="text" id="contact" class="form-control" maxlength="11" name="contact" value="<?php echo $showContacts['contact']?>">					
						</div>
					</div>
					<div class="form-group">
						<label for="" class="control-label">Address</label>
						<input type="text" class="form-control" id="address" name="customer_address" value="<?php echo $showContacts['customer_address'] ?>" required>
					</div>
					<?php } ?>
					<!-- /contact number -->
			</div>
			<u class="fw-bold text-primary text-center mt-3 mb-3"><h5 class="fw-bold text-primary text-center mt-3 mb-3">TRANSACTION</h5></u>
			<div class="row">
					<div class="form-group col-md-6">
						<label for="remarks" class="control-label">Remarks</label>
						<textarea name="remarks" id="remarks" cols="30" rows="2" class="form-control"><?php echo isset($remarks) ? $remarks : '' ?></textarea>
					</div>
					<!-- Washing Machine -->
					<?php if(isset($_GET['id'])): ?>
						<div class="col-md-6">
							<div class="form-group">
									<label for="washing" class="control-label">Select Washing Machine</label>
									<select name="washing" id="washing" class="custom-select browser-default">
										<?php 
										$sql1 = "SELECT * FROM laundry_list where id =".$_GET['id'];
										$list1 = $conn->query($sql1) or die($conn->error);
										$list2 = $list1->fetch_assoc();
										?>
										<?php 
										$sql = "SELECT * FROM washing_list";
										$list = $conn->query($sql) or die($conn->error);

										while($lists = $list->fetch_assoc()): ?>
										<option value="<?php echo $lists['name']; ?>" <?= ($list2['washing_id'] == $lists['name'])? 'selected' : '' ?>><?php echo $lists['name']; ?></option>
										<?php endwhile; ?>
									</select>
									
							</div>
						</div>
					<?php endif; ?>

					<?php if(!isset($_GET['id'])): ?>
					<div class="col-md-6">
							<div class="form-group">
									<label for="washing" class="control-label">Washing Machine</label>
									<select name="washing" id="washing" class="custom-select browser-default">
									<option selected disabled hidden>--Select Washing Machine--</option>
										<?php 
										// $sql = "SELECT * FROM washing_list WHERE status='Active'";
										$sql = "SELECT * FROM washing_list WHERE status='Active'";
										$list = $conn->query($sql) or die($conn->error);
										while($lists = $list->fetch_assoc()): ?>
										<option value="<?php echo $lists['name']; ?>"><?php echo $lists['name'];?></option>
										<?php endwhile; ?>
									</select>
									<br><br>
							</div>
					</div>
					<?php endif; ?>
			</div>
			<hr>	
			<strong class="fw-bold text-danger text-left my-3">Note: Maximum of 8 kg. clothes is equivalent to 1 unit/quantity.</strong>
			<div class="row justify-content-between align-items-center">
				<div class="col-4">	
					<div class="form-group">	
						<label for="" class="control-label">Laundry Category (SERVICE)</label>
						<select class="form-control custom-select browser-default" id="laundry_category_id">
							<?php 
								$cat = $conn->query("SELECT * FROM laundry_categories order by name asc");
								while($row = $cat->fetch_assoc()):
									$cname_arr[$row['id']] = $row['name'];
							?>
							<option value="<?php echo $row['id'] ?>" data-price="<?php echo $row['price'] ?>"><?php echo $row['name'] ?></option>
							<?php endwhile; ?>
						</select>
					</div>
				</div>
				<div class="col-4">	
					<div class="form-group">	
						<label for="" class="control-label">Quantity</label>
						<input type="number" step="any" min="1" value="1" class="form-control text-right" id="weight">
					</div>
					
				</div>
				<div class="col-4">	
					<div class="form-group mt-4">
						<button class="btn btn-info btn-sm btn-block" type="button" id="add_to_list"><i class="fa fa-plus"></i> Add to List</button>
					</div>
				</div>
			</div>
			<br>
			<div class="row justify-content-between align-items-center">
				<div class="col-4">	
					<div class="form-group">	
						<label for="" class="control-label">Laundry Category (PRODUCT)</label>
						<select class="form-control custom-select browser-default" id="laundry_category_id">
							<?php 
								$cat = $conn->query("SELECT * FROM laundry_categories order by name asc");
								while($row = $cat->fetch_assoc()):
									$cname_arr[$row['id']] = $row['name'];
							?>
							<option value="<?php echo $row['id'] ?>" data-price="<?php echo $row['price'] ?>"><?php echo $row['name'] ?></option>
							<?php endwhile; ?>
						</select>
					</div>
				</div>
				<div class="col-4">	
					<div class="form-group">	
						<label for="" class="control-label">Quantity</label>
						<input type="number" step="any" min="1" value="1" class="form-control text-right" id="weight">
					</div>
					
				</div>
				<div class="col-4">	
					<div class="form-group mt-4">
						<button class="btn btn-info btn-sm btn-block" type="button" id="add_to_list"><i class="fa fa-plus"></i> Add to List</button>
					</div>
				</div>
			</div>
			<br>
			<hr>
			<u class="fw-bold text-primary text-center mt-3 mb-3"><h5 class="fw-bold text-primary text-center my-3">LIST OF ITEMS</h5></u>
			<div class="row">	
				<table class="table table-bordered" id="list">
					<colgroup>	
						<col width="30%">
						<col width="15%">
						<col width="25%">
						<col width="25%">
						<col width="5%">
					</colgroup>	
					<thead>	
						<tr>
							<th class="text-center">Category</th>
							<th class="text-center">Quantity</th>
							<th class="text-center">Unit Price</th>
							<th class="text-center">Amount</th>
							<th class="text-center"></th>
						</tr>
					</thead>
					<tbody>
						<?php if(isset($_GET['id'])): ?>
						<?php 
							$list = $conn->query("SELECT * from laundry_items where laundry_id = ".$id);
							while($row=$list->fetch_assoc()):
						?>
							<tr data-id="<?php echo $row['id'] ?>">
								<td class="">
									<input type="hidden" name="item_id[]" id="" value="<?php echo $row['id'] ?>">
									<input type="hidden" name="laundry_category_id[]" id="" value="<?php echo $row['laundry_category_id'] ?>"><?php echo isset($cname_arr[$row['laundry_category_id']]) ? ucwords($cname_arr[$row['laundry_category_id']]) : '' ?></td>
								<td><input type="number" class="text-center" name="weight[]" id="" value="<?php echo $row['weight'] ?>"></td>
								<td class="text-right"><input type="hidden" name="unit_price[]" id="" value="<?php echo $row['unit_price'] ?>"><?php echo number_format($row['unit_price'],2) ?></td>
								<td class="text-right"><input type="hidden" name="amount[]" id="" value="<?php echo $row['amount'] ?>"><p><?php echo number_format($row['amount'],2) ?></p></td>
								<td><button class="btn btn-sm btn-danger" type="button" onclick="rem_list($(this))"><i class="fa fa-times"></i></button></td>
							</tr>
						<?php endwhile; ?>
						<?php endif; ?>
					</tbody>	
				</table>
			</div>	
			<hr>
			<div class="row justify-content-between align-items-center">
				<div class="col-4 form-group">
					<div class="custom-control custom-switch" id="pay-switch">
					  <input type="checkbox" class="custom-control-input" value="1" name="pay" id="paid" <?php echo isset($pay_status) && $pay_status == 1 ? 'checked' :'' ?>>
					  <label class="custom-control-label" for="paid">Pay</label>
					</div>
				</div>
			</div>
			<u class="fw-bold text-primary text-center mt-3 mb-3"><h5 class="fw-bold text-primary text-center mt-3 mb-3">PAYMENT</h5></u>
			<div class="row justify-content-between align-items-center" id="payment">
				<div class="col-md-6">
					<div class="form-group">	
						<label for="" class="control-label">Amount Tendered</label>
						<input type="number" min="0" value="<?= isset($amount_tendered) ? $amount_tendered : 0 ; ?>" class="form-control text-right" name="tendered">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">	
						<label for="tamount" class="control-label">Total Amount</label>
						<input type="number" min="1" value="<?= isset($total_amount) ? $total_amount : 0 ; ?>" class="form-control text-right" name="tamount" id="tamount" readonly>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">	
						<label for="change" class="control-label">Change</label>
						<input type="number" min="1" value="<?= isset($amount_change) ? $amount_change : 0 ; ?>" class="form-control text-right" name="change" id="change" readonly>
					</div>
				</div>
			</div>
			<div class="row justify-content-around align-items-center">
				<div class="col-md-5">
					<div class="form-group">	
						<input type="submit" value="Save" class="btn btn-primary btn-block" id='submit'>
					</div>
				</div>
				<div class="col-md-5">
					<div class="form-group">	
						<button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">Cancel</button>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
<script>
	$(function(){
			if('<?php echo isset($_GET['id']) ?>' == 1){
			calc()
		}
	if($('#uni_modal [name="pay"]').prop('checked') == true){
			$('#uni_modal input[name="tendered"]').prop('required',true)
			$('#uni_modal #payment').show();
	}else{
			$('#payment').hide();
			$('#uni_modal input[name="tendered"]').prop('required',false)
	}	
	$('#uni_modal #pay-switch').on('change', function(){
		if($('#uni_modal [name="pay"]').prop('checked') == true){
			$('#uni_modal input[name="tendered"]').prop('required',true)
			$('#uni_modal #payment').show('slideDown');
		}else{
			$('#payment').hide('SlideUp');
			$('#uni_modal input[name="tendered"]').prop('required',false)
		}	
	})

	
	$('#uni_modal [name="tendered"],#uni_modal [name="tamount"]').on('keypup keydown keypress change input',function(){
		var tend = $('#uni_modal [name="tendered"]').val();
		var amount = $('#uni_modal [name="tamount"]').val();
		var change = parseFloat(tend) - parseFloat(amount)
		change = parseFloat(change).toLocaleString('en-US',{style:'decimal',maximumFractionDigits:2,minimumFractionDigits:2})
		$('#uni_modal [name="change"]').val(Math.abs(change))
	})
	$('#uni_modal #add_to_list').click(function(){
		var cat = $('#uni_modal #laundry_category_id').val(),
			_weight = $('#uni_modal #weight').val();
		if(cat == '' || _weight ==''){
			alert_toast('Fill the category and weight fields first.','warning')
			return false;
		}
		if($('#uni_modal #list tr[data-id="'+cat+'"]').length > 0){
			alert_toast('Category already exist.','warning')
			return false;
		}
		var price = $('#uni_modal #laundry_category_id option[value="'+cat+'"]').attr('data-price');
		var cname = $('#uni_modal #laundry_category_id option[value="'+cat+'"]').html();
		var amount = parseFloat(price) * parseFloat(_weight);
		var tr = $('<tr></tr>');
		tr.attr('data-id',cat)
		tr.append('<input type="hidden" name="item_id[]" id="" value=""><td class=""><input type="hidden" name="laundry_category_id[]" id="" value="'+cat+'">'+cname+'</td>')
		tr.append('<td><input type="number" class="text-center" name="weight[]" id="" value="'+_weight+'"></td>')
		tr.append('<td class="text-right"><input type="hidden" name="unit_price[]" id="" value="'+price+'">'+(parseFloat(price).toLocaleString('en-US',{style:'decimal',maximumFractionDigits:2,minimumFractionDigits:2}))+'</td>')
		tr.append('<td class="text-right"><input type="hidden" name="amount[]" id="" value="'+amount+'"><p>'+(parseFloat(amount).toLocaleString('en-US',{style:'decimal',maximumFractionDigits:2,minimumFractionDigits:2}))+'</p></td>')
		tr.append('<td><button class="btn btn-sm btn-danger" type="button" onclick="rem_list($(this))"><i class="fa fa-times"></i></button></td>')
		$('#uni_modal table#list tbody').append(tr)
		calc()
		$('#uni_modal [name="weight[]"]').on('keyup keydown keypress change',function(){
			calc();
		})
			$('#uni_modal [name="tendered"]').trigger('keypress')
		
		$('#uni_modal #laundry_category_id').val('')
		$('#uni_modal #weight').val('')
	})
	function rem_list(_this){
		_this.closest('tr').remove()
		calc()
		$('#uni_modal [name="tendered"]').trigger('keypress')
	}
	function calc(){
		var total = 0;
		$('#uni_modal table#list tbody tr').each(function(){
			var _this = $(this)
			var weight = _this.find('[name="weight[]"]').val()
			var unit_price = _this.find('[name="unit_price[]"]').val()
			var amount = parseFloat(weight) * parseFloat(unit_price)
			_this.find('[name="amount[]"]').val(amount)
			_this.find('[name="amount[]"]').siblings('p').html(parseFloat(amount).toLocaleString('en-US',{style:'decimal',maximumFractionDigits:2,minimumFractionDigits:2}))
			total+= amount;

		})
			$('#uni_modal [name="tamount"]').val(total)
			$('#uni_modal #tamount').html(parseFloat(total).toLocaleString('en-US',{style:'decimal',maximumFractionDigits:2,minimumFractionDigits:2}))
	}
	$('#manage-laundry').on('submit', function(e){
		e.preventDefault()
		// if($('input[name="tendered"]').attr('required') == 'required'){
		// 	if(
		// 	$('input[name="tendered"]').val() == 0 
		// 	|| $('input[name="tendered"]').val() == '' 
		// 	|| $('input[name="tendered"]').val() == '0.00'){
		// 		alert_toast('Fill the amount tendered first!','warning')
		// 		return;
		// 	}
		// }

		$.ajax({
			url:'ajax.php?action=save_laundry',
			data: new FormData($(this)[0]),
			cache: false,
			contentType: false,
			processData: false,
			method: 'POST',
			type: 'POST',
			success: function(resp){
				location.reload();
			}
		})
	})

	$('.btn-bind-user').on('click', function(e){
		e.preventDefault();
		$tr = $(this).closest('tr');
		var data = $tr.children("td").map(function () {
			return $(this).text();
		}).get();
		$("#uni_modal input#fname").val($.trim(data[1]))
		$("#uni_modal input#lname").val($.trim(data[2]))
		$("#uni_modal input#contact").val($.trim(data[3]))
		$("#uni_modal input#address").val($.trim(data[4]))
	})

	$('#laundry-list').dataTable()
	})
</script>
