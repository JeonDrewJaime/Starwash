<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Login | Star Wash Laundry Shop</title>
  <?php include('./header.php'); ?>
  <?php include('./db_connect.php'); ?>
  <?php
  session_start();
  if (isset($_SESSION['login_id']))
    header("location:index.php?page=home");
  ?>
</head>

<style>
  body {
    margin: 0;
    padding: 0;
    width: 100%;
    height: 100vh;
    overflow: hidden;
  }

  main#main {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background-image: url("./assets/img/LoginBGs.jpg");
    background-size: cover;
    background-position: center;
  }

  #login-container {
    display: flex;
    width: 100%;
   
    height: 100%;
    background: rgba(255, 255, 255, 0.8);
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
  }

  #login-left {
    flex: 1.5; /* Wider left section */
    display: flex;
    align-items: center;
    justify-content: center;
    background-image: url("./assets/img/laundryBG.jpg");
    background-size: cover;
    background-position: center;
  }

  #login-right {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    background-image: url("./assets/img/bubss.jpg");
    background-size: cover;
    background-position: center;
  }

  .card {
    background: rgba(255, 255, 255, 0.9);
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    width: 90%;
    max-width: 400px;
    text-align: center;
  }

  .logo img {
    width: 150px;
    height: auto;
    margin-bottom: 20px;
  }

  .form-group {
    margin-bottom: 15px;
    text-align: left;
  }

  .form-control {
    width: 100%;
    padding: 10px;
    border-radius: 25px;
    border: 1px solid #ccc;
    font-size: 16px;
  }

  .btn-block {
    width: 100%;
    padding: 10px;
    border-radius: 25px;
    background-color: #59b6ec;
    color: white;
    border: none;
    font-size: 16px;
    cursor: pointer;
  }

  .btn-block:hover {
    background-color: #4aa1d1;
  }

  .text {
    font-size: 18px;
    color: #333;
    margin-bottom: 20px;
  }

  .date-time {
    margin-top: 20px;
    font-size: 14px;
    color: #555;
  }

  @media (max-width: 1200px) {
    #login-container {
      max-width: 1200px; /* Adjust for smaller monitors */
    }
  }

  @media (max-width: 768px) {
    #login-container {
      flex-direction: column;
      height: 90%;
      max-width: 100%;
    }

  
    #login-left{
      flex: none;
      width: 100%;
      height:25vh;
    }

	#login-right {
      flex: none;
      width: 100%;
      height: 75vh;
    }
    .card {
      margin: 20px auto;
    }
	body {
        height: 100%;
    }
  }
</style>

<body onload="display_ct()">
  <main id="main">
    <div id="login-container">
      <div id="login-left">
        <div class="logo">
          <img src="assets/img/StarWash.png" alt="StarWash Logo">
        </div>
      </div>
      <div id="login-right">
        <div class="card">
          <div class="logo">
            <img src="assets/img/StarWash.png" alt="StarWash Logo">
          </div>
          <div class="text">
            <center>
              <h5>A NEW INNOVATION FOR LAUNDRY</h5>
            </center>
          </div>
          <form id="login-form">
            <div class="form-group">
              <label for="username">Username</label>
              <input type="text" id="username" name="username" class="form-control" placeholder="Username" required>
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
              <label for="show-password">Show Password</label>
              <input type="checkbox" id="show-password" onclick="togglePassword()">
            </div>
            <button type="submit" class="btn btn-block">Login</button>
          </form>
          <div class="date-time">
            <center>
              <strong>
                <p><span id="date"></span></p>
                <p><span id="time"></span></p>
              </strong>
            </center>
          </div>
        </div>
      </div>
    </div>
  </main>

  <script>
    function display_ct() {
      var date = new Date().toLocaleDateString();
      var time = new Date().toLocaleTimeString();
      document.getElementById('date').innerHTML = "Date: " + date;
      document.getElementById('time').innerHTML = "Time: " + time;
      setTimeout(display_ct, 1000);
    }

    function togglePassword() {
      var passwordField = document.getElementById('password');
      if (passwordField.type === 'password') {
        passwordField.type = 'text';
      } else {
        passwordField.type = 'password';
      }
    }

    $('#login-form').submit(function (e) {
      e.preventDefault();
      $('button[type="submit"]').attr('disabled', true).html('Logging in...');
      if ($(this).find('.alert-danger').length > 0)
        $(this).find('.alert-danger').remove();
      $.ajax({
        url: 'ajax.php?action=login',
        method: 'POST',
        data: $(this).serialize(),
        dataType: "text",
        error: function (err) {
          console.log(err);
          $('button[type="submit"]').removeAttr('disabled').html('Login');
        },
        success: function (resp) {
          if (resp == 1) {
            location.href = 'index.php?page=home';
          } else if (resp == 2) {
            location.href = 'voting.php';
          } else {
            $('#login-form').prepend('<div class="alert alert-danger">Username or password is incorrect.</div>');
            $('button[type="submit"]').removeAttr('disabled').html('Login');
          }
        }
      });
    });
  </script>
</body>

</html>