<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Login |Star Wash Laundry Shop</title>
 	

<?php include('./header.php'); ?>
<?php include('./db_connect.php'); ?>
<?php 
session_start();
if(isset($_SESSION['login_id']))
header("location:index.php?page=home");

?>

</head>
<style>
	body{
		width:100%;
		height:100%;
	}
	main#main{
		width:100%;
		height:100%;
		background-image: url("./assets/img/LoginBGs.jpg");
	}
	#login-right{
		position: absolute;
		right:0;
		width:40%;
		margin:auto;
		background-position: center;
  		background-repeat: no-repeat;
  		background-size: cover;
		height: calc(100%);
		background-image: url("./assets/img/bubss.jpg");
		display: flex;
		align-items: center;
	}
	#login-left{
		position: absolute;
		left:0;
		width:60%;
		background-position: center;
		height: calc(100%);
		background-repeat: no-repeat;
		background-size: cover;
	    background-image: url("./assets/img/laundryBG.jpg");
		display: flex;
		align-items: center;
		
	}
	#login-right .card{
		margin: auto;
		
	}
	.logo {
    margin: auto;
	height:10%;
	margin-top:-210px;
    font-size: 10rem;
    padding: .5em 0.7em;
    border-radius: 50% 50%;
    color: #000000b3;
}
.btn-block{
	border-radius: 25px;
	background-color: #59b6ec61;
	color:gray;
	border-color:#59b6ec61;

}
.btn-block:hover{
	background-color: #59b6ec61;
	color:gray;
}
.col-md-8{
	border-radius:25px;
	height:500px;
	border-color: #00ffff;
}
.text{
	margin-top:140px;
	font-size: 20px;
}
.form-control{
	border-radius: 25px;
	height:50px
}
.picture{
	height:10px;
	width:200px;
	position: center;
	margin:auto;
}
.date{
	margin: auto;
	height:10px;
	margin-top:-210px;
    font-size: 8rem;
    padding: .5em 0.7em;
    border-radius: 50% 50%;
    color: #000000b3;

}
</style>

<body onload=display_ct()>


  <main id="main" class=" bg-dark">
  		<div id="login-left">
  			<div class="logo">
  				<!-- <div class="laundry-logo"></div> -->




					<script>
					function runTime(){
						var refresh=1000; // Refresh rate in milli seconds
						mytime=setTimeout('display_ct()',refresh)
					}

					function display_ct() {
						var date = new Date().toLocaleDateString()
						var time = new Date().toLocaleTimeString()
						document.getElementById('date').innerHTML = "Date : " + date;
						document.getElementById('time').innerHTML = "Time : " + time;
						runTime();
					}
					</script>
	</center>				  

  			</div>
  		</div>
  		<div id="login-right">
  			<div class="card border-info col-md-9">
				  	<div class="picture">
					 <center> <img src="assets/img/StarWash.png" alt="StarWashLogo"  width="200px" height="180px"> </center>
				   </div>
				   <br><br>
				  <div class="text">
				  <center><h5 class="p1">A NEW INNOVATION FOR LAUNDRY</h5></center>
  				<div class="card-body">
  					<form id="login-form" >
  						<div class="form-group">
  							<label for="username" class="control-label">Username</label>
  							<input type="text" id="username" name="username" class="form-control" placeholder="Username">
  						</div>
  						<div class="form-group">
  							<label for="password" class="control-label">Password</label> 
  							<input type="password" id="password" name="password" class="form-control" placeholder="Password">
							 <br> 
							  <label for="password">Show password</label>
								<input type="checkbox" onclick="myfucntion()">
								<script>
								function myfucntion() {
  								var x = document.getElementById("password");
  								if (x.type === "password") {
   								 x.type = "text";
 								 } else {
   								 x.type = "password";
  										}
										}	
						</script>
  						</div>
						 
  						<center><button class="btn btn-primary btn-lg btn-block">Login</button></center>
  					</form>
		<center>
		<hr>
		<strong><p style=" font-style: normal; color:black;"><span id="date"></span></p></strong>
		<strong><p style="font-style: normal; color:black;"><span id="time"></span></p></strong>
		<hr>
		</center>
  				</div>
  			</div>
  		</div>
   

  </main>

  <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>


</body>
<script>
	$('#login-form').submit(function(e){
		e.preventDefault()
		$('#login-form button[type="button"]').attr('disabled',true).html('Logging in...');
		if($(this).find('.alert-danger').length > 0 )
			$(this).find('.alert-danger').remove();
		$.ajax({
			url:'ajax.php?action=login',
			method:'POST',
			data:$(this).serialize(),
			dataType: "text",
			error:err=>{
				console.log(err)
				$('#login-form button[type="button"]').removeAttr('disabled').html('Login');
			},
			success:function(resp){
				console.log(resp)
				if(resp == 1){
					location.href ='index.php?page=home';
				}else if(resp == 2){
					location.href ='voting.php';
				}else{
					$('#login-form').prepend('<div class="alert alert-danger">Username or password is incorrect.</div>')
					$('#login-form button[type="button"]').removeAttr('disabled').html('Login');
				}
			}
		})
	})
</script>	
</html>