<div class='sidebar' id="sidebar" class='mx-lt-5 bg-info' >
		<div class="sidebar-list">
		<!--  Change Button Color (style="background-color:#00b2ff;)-->
				<a href="index.php?page=home" class="nav-item nav-home"><span class='icon-field'><i class="fa fa-home"></i></span> Home</a>
				<a href="index.php?page=laundry" class="nav-item nav-laundry"><span class='icon-field'><i class="fa fa-water"></i></span> Laundry List</a>
				<a href="index.php?page=categories" class="nav-item nav-categories"><span class='icon-field'><i class="fa fa-list"></i></span> Laundry Category</a>	
				<a href="index.php?page=supply" class="nav-item nav-supply"><span class='icon-field'><i class="fa fa-boxes"></i></span> Supply List</a>	
				<a href="index.php?page=inventory" class="nav-item nav-inventory"><span class='icon-field'><i class="fa fa-list-alt"></i></span> Inventory</a>
				<a href="index.php?page=washing_machine" class="nav-item nav-washing_machine"><span class='icon-field'><i class="far fa-list-alt"></i></span> Washing Machine List</a>	

				<a href="index.php?page=sms" class="nav-item nav-sms"><span class='icon-field'><i class="fa fa-address-book" aria-hidden="true"></i></span> SMS Notification</a>
				<?php if($_SESSION['login_type'] == 1): ?>
				<a href="index.php?page=reports" class="nav-item nav-reports"><span class='icon-field'><i class="fa fa-th-list"></i></span> Reports</a>				
				<a href="index.php?page=users" class="nav-item nav-users"><span class='icon-field'><i class="fa fa-users"></i></span> Users</a>
			<?php endif; ?>
			<?php if($_SESSION['login_type'] == 1): ?>
			<center> <img src="assets/img/StarWash.png" alt="" style=" margin-top:-1030px; margin-left:0px;width:150px;height:150px;"> </center>
			<center><b id="runningDate" class="text-center mb-0 pa-0"></b></center>
			<center><b id="runningTime" class="text-center mb-0 pa-0"></b></center>
			<?php endif; ?>

			<?php if($_SESSION['login_type'] == 2): ?>
			<center> <img src="assets/img/StarWash.png" alt="" style=" margin-top:-840px; margin-left:0px;width:150px;height:150px;"> </center>
			<center><b id="runningDate" class="text-center mb-0 pa-0"></b></center>
			<center><b id="runningTime" class="text-center mb-0 pa-0"></b></center>
			<?php endif; ?>
		</div>
</div>
<script>
	$('.nav-<?php echo isset($_GET['page']) ? $_GET['page'] : '' ?>').addClass('active')
</script>
<?php if($_SESSION['login_type'] == 2): ?>
	<style>
		.nav-sales ,.nav-users{
			display: none!important;
		}
	</style>
<?php endif ?>