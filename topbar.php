<style>
	.logo {
    margin: auto;
}
.navbar{
	height: 70px;
	width: 100%;
	position: fixed;
	top: 0;
	left: 0;
}
.navbar-container{
	height: 50px;
	width: 80%;
	margin: 0 auto;
	max-width: 2000px;
	display: flex;
	justify-content: space-between;
	align-items: center;
}
.p1{
	font-family: 'Shizuru', cursive;
	height: 120px;
	width: 80%;
	color:white;
	margin-left: -150px;
	max-width: 2000px;
	display: flex;
	justify-content: space-between;
	align-items: center;
}
.logout-container h6{
	height: 120px;
	line-height: 120px;
	margin: auto 0 !important;
}
.logout-container{
	height: 120px;
	display: flex;
	justify-content: space-evenly;
	align-items:center;
}
</style>

<nav class="navbar navbar-dark bg-info" style="padding:0;">
<!-- <a href="ajax.php?action=logout" class="text-white" ><?php echo "Hi, I'm " .$_SESSION['login_first_name']." ".$_SESSION ['login_last_name'] ?> <i class="fas fa-sign-out-alt"></i></a> -->
	<div class="navbar-container">
	<h3 class="p1" >STAR WASH LAUNDRY SHOP</h3>
		<div class="logout-container">
			<strong class="text-white"><?php echo "Hi, I'm " .$_SESSION['login_first_name']." ".$_SESSION ['login_last_name'] ?></strong>
			<a class="ml-4" href="ajax.php?action=logout"><i class="fas fa-sign-out-alt fa-2x text-white"></i></a>
		</div>
	</div>
  
</nav>