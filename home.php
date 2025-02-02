<style>
  .helloContainer {
    height: 228px;
    width: 98.5%;
    margin: 10px auto;
    border-radius: 25px;
    background-color: #c7eced;
  }

  .welcomeContainer {
    height: 180px;
    width: 96.5%;
    margin: 25px auto;
    border-radius: 25px;
    background-color: #def9ff;
  }

  .user-photo {
    height: 150px;
    width: 150px;
    float: right;
    border-radius: 50%;
    background-color: #9bc9b2;
    border: 2px solid #000;
    margin: -7px 30px 0 0;
  }

  .BoomLogo {
    height: 50px;
    width: 100%;
    margin: -280px 0 0 265px;
    border-radius: 50px;
    background-color: white;
  }

  .card {
    display: flex;
    justify-content: center; /* Horizontally center content */
    align-items: center; /* Vertically center content */
    flex-direction: column; /* Stack content vertically */
	padding: 30px;
  }

  .alert {
    margin-bottom: 15px;
  }

  .stat-card {
    display: flex;
    flex: 1;
    justify-content: center;
    align-items: center;
    height: 150px; /* Fixed height for equal size cards */
    margin: 10px;
    border-radius: 15px;
    background-color: #f0f0f0;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  }

  .stat-card img {
    width: 50px;
    height: 50px;
    margin-right: 15px;
  }

  .stat-card div {
    display: flex;
    flex-direction: column;
    align-items: center;
  }

  .stat-card p {
    margin: 0;
  }

  @media (max-width: 768px) {
  .helloContainer, .welcomeContainer {
    width: 100%; /* Make these containers span the full width */
  }

  .stat-card {
    height: 100px; /* Adjust height for smaller screens */
  }

  .user-photo {
    height: 120px;
    width: 120px;
    margin: 0 auto 10px; /* Center the photo and give it space from the text */
    display: block; /* Make the image block-level to center it */
  }

  /* Center the welcome message and image in the middle */
  .welcomeContainer {
    display: flex;
    flex-direction: column; /* Stack content vertically */
    justify-content: center; /* Center content vertically */
    align-items: center; /* Center content horizontally */
    text-align: center; /* Center the text */
    padding: 20px 0; /* Add some padding for better spacing */
  }

  .card-body {
    padding: 10px;
  }

  .stat-card {
    flex-direction: column; /* Stack stat icon and text vertically */
    height: auto;
  }

  .stat-card img {
    margin-bottom: 10px; /* Space between icon and text */
  }
}


</style>

<div class="container-fluid">
  <div class="row mt-3 mx-2">
    <div class="col-12">
      <div class="card">
        <div class="helloContainer">
          <div class="welcomeContainer">
            <div class="card-body">
              <b>
                <?php echo "Hello " . $_SESSION['login_first_name'] . " " . $_SESSION['login_last_name'] . ", Welcome Back!" ?>
              </b>
              <img class="user-photo" src="<?= $_SESSION['login_image'] != '' ? $_SESSION['login_image'] : './assets/img/defaultuser.png' ?>" alt="login_last_name">
            </div>
          </div>
        </div>

        <hr>

        <div class="row text-center">
          <!-- Total Sales Today -->
          <div class="alert alert-success col-md-3 mx-2 stat-card">
            <img src="assets/img/ProfitIcon.png" alt="Profit Icon" class="stat-icon">
            <div>
              <p><b>Total Sales Today</b></p>
              <p>
                <b><?php include 'db_connect.php';
                  $laundry = $conn->query("SELECT SUM(total_amount) as amount FROM laundry_list WHERE pay_status = 1 AND DATE(date_created) = '" . date('Y-m-d') . "'");
                  echo $laundry->num_rows > 0 ? number_format($laundry->fetch_array()['amount'], 2) : "0";
                ?></b>
              </p>
            </div>
          </div>

          <!-- Total Customer Today -->
          <div class="alert alert-primary col-md-4 mx-2 stat-card">
            <img src="assets/img/CustomerIcon.png" alt="Customer Icon" class="stat-icon">
            <div>
              <p><b>Total Customer Today</b></p>
              <p>
                <b><?php include 'db_connect.php';
                  $laundry = $conn->query("SELECT COUNT(id) as count FROM laundry_list WHERE DATE(date_created) = '" . date('Y-m-d') . "'");
                  echo $laundry->num_rows > 0 ? number_format($laundry->fetch_array()['count']) : "0";
                ?></b>
              </p>
            </div>
          </div>

          <!-- Monthly Income -->
          <div class="alert alert-success col-md-3 mx-2 stat-card">
            <img src="assets/img/MonthlyIncomeIcon.png" alt="Income Icon" class="stat-icon">
            <div>
              <p><b>Monthly Income</b></p>
              <p>
                <b><?php include 'db_connect.php';
                  $laundry = $conn->query("SELECT SUM(total_amount) as amount FROM laundry_list WHERE pay_status = 1 AND MONTH(date_created) = MONTH(CURRENT_DATE())");
                  echo $laundry->num_rows > 0 ? number_format($laundry->fetch_array()['amount'], 2) : "0";
                ?></b>
              </p>
            </div>
          </div>
        </div>

        <div class="row text-center">
          <!-- Total Laundry Machines -->
          <div class="alert alert-info col-md-3 mx-2 stat-card">
            <img src="assets/img/WashingIcon.png" alt="Washing Icon" class="stat-icon">
            <div>
              <p><b>Total Laundry Machines</b></p>
              <p>
                <b><?php include 'db_connect.php';
                  $laundry = $conn->query("SELECT COUNT(id) as count FROM washing_list");
                  echo $laundry->num_rows > 0 ? number_format($laundry->fetch_array()['count']) : "0";
                ?></b>
              </p>
            </div>
          </div>

          <!-- Total Claimed Laundry Today -->
          <div class="alert alert-warning col-md-4 mx-2 stat-card">
            <img src="assets/img/ClaimedIcon.png" alt="Claimed Icon" class="stat-icon">
            <div>
              <p><b>Total Claimed Laundry Today</b></p>
              <p>
                <b><?php include 'db_connect.php';
                  $laundry = $conn->query("SELECT COUNT(id) as count FROM laundry_list WHERE status = 3 AND DATE(date_created) = '" . date('Y-m-d') . "'");
                  echo $laundry->num_rows > 0 ? number_format($laundry->fetch_array()['count']) : "0";
                ?></b>
              </p>
            </div>
          </div>

          <!-- Total Unclaimed Laundry Today -->
          <div class="alert alert-danger col-md-3 mx-2 stat-card">
            <img src="assets/img/PendingIcon.png" alt="Pending Icon" class="stat-icon">
            <div>
              <p><b>Total Unclaimed Laundry Today</b></p>
              <p>
                <b><?php include 'db_connect.php';
                  $laundry = $conn->query("SELECT COUNT(id) as count FROM laundry_list WHERE status = 2 AND DATE(date_created) = '" . date('Y-m-d') . "'");
                  echo $laundry->num_rows > 0 ? number_format($laundry->fetch_array()['count']) : "0";
                ?></b>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
