<div class="navbar bg-info d-flex align-items-center justify-content-between px-3">
  <button class="menu-toggle btn text-white" id="menuToggle">
    <i class="fa fa-bars" aria-hidden="true"></i>
  </button>

  <div class="navbar-container d-flex align-items-center justify-content-between flex-grow-1">
    <h3 class="text-white mb-0 site-title">STAR WASH LAUNDRY SHOP</h3>
    <div class="logout-container d-flex align-items-center">
      <strong class="text-white mr-3">
        <?php echo "Hi, I'm " . $_SESSION['login_first_name'] . " " . $_SESSION['login_last_name']; ?>
      </strong>
      <a href="ajax.php?action=logout" class="text-white">
        <i class="fas fa-sign-out-alt fa-2x"></i>
      </a>
    </div>
  </div>
</div>

<div class="sidebar" id="sidebar">
<center><img src="assets/img/StarWash.png" alt="Logo" class="sidebar-logo"></center>
  <div class="sidebar-list">
    <a href="index.php?page=home" class="nav-item nav-home"><span class='icon-field'><i class="fa fa-home"></i></span> Home</a>
    <a href="index.php?page=laundry" class="nav-item nav-laundry"><span class='icon-field'><i class="fa fa-water"></i></span> Laundry List</a>
    <a href="index.php?page=categories" class="nav-item nav-categories"><span class='icon-field'><i class="fa fa-list"></i></span> Laundry Category</a>
    <a href="index.php?page=supply" class="nav-item nav-supply"><span class='icon-field'><i class="fa fa-boxes"></i></span> Supply List</a>
    <a href="index.php?page=inventory" class="nav-item nav-inventory"><span class='icon-field'><i class="fa fa-list-alt"></i></span> Inventory</a>
    <a href="index.php?page=washing_machine" class="nav-item nav-washing_machine"><span class='icon-field'><i class="far fa-list-alt"></i></span> Washing Machine List</a>
    <a href="index.php?page=email" class="nav-item nav-email"><span class='icon-field'><i class="fa fa-envelope" aria-hidden="true"></i></span> Email Notification</a>
    <?php if ($_SESSION['login_type'] == 1): ?>
    <a href="index.php?page=reports" class="nav-item nav-reports"><span class='icon-field'><i class="fa fa-th-list"></i></span> Reports</a>
    <a href="index.php?page=users" class="nav-item nav-users"><span class='icon-field'><i class="fa fa-users"></i></span> Users</a>
    <?php endif; ?>
    <center><b id="runningDate" class="text-center mb-0" ></b></center>
    <center><b id="runningTime" class="text-center mt-0"></b></center>
  </div>
</div>

<script>
  document.getElementById('menuToggle').addEventListener('click', function () {
    document.getElementById('sidebar').classList.toggle('active');
  });

  document.querySelector('.nav-<?php echo isset($_GET['page']) ? $_GET['page'] : '' ?>').classList.add('active');
</script>

<style>
  /* General Styling */
  .navbar {
    display: flex;
    align-items: center;
    background-color: #00b2ff;
    padding: 10px;
    position: fixed;
    z-index: 9999; /* High z-index to make it always on top */
  }

  .menu-toggle {
    background: none;
    border: none;
    font-size: 24px;
    cursor: pointer;
  }

  .logout-container {
    display: flex;
    align-items: center;
  }

  .sidebar {
  position: fixed;
  left: 0;
  top: 0;
  bottom: 0;
  width: 250px;
  background-color:rgb(179, 214, 224); /* Add your desired background color here */
  overflow-y: auto;
  transform: translateX(-100%);
  transition: transform 0.3s ease;
  z-index: 1000;
}
  .sidebar.active {
    transform: translateX(0);
  }

  .sidebar-list a {
    display: block;
    padding: 10px 15px;
    color: black;
    background-color:rgb(179, 214, 224); /* Add your desired background color here */
    text-decoration: none;
    transition: background 0.2s;
  }

  .sidebar-logo {
    width: 150px;
    height: auto;
    margin: 15px 0;
  }

  /* Responsive Styles */
  @media (max-width: 768px) {
    .sidebar {
      transform: translateX(-100%);
    }
    .site-title {
      font-size: 18px;
    }
    .menu-toggle {
      display: block;
    }
  }

  @media (min-width: 769px) {
    .menu-toggle {
      display: none;
    }

    .sidebar {
      transform: translateX(0);
    }
  }
</style>
