<body id="body-pd">
  <div class="l-navbar m-3 rounded shadow" id="nav-bar">
    <nav class="nav">
      <div class="nav_link" id="header">
        <div class="header_toggle">
          <i class="bx bx-menu-alt-left nav_icon" id="header-toggle"></i>
        </div>
      </div>
      <div class="nav_list">
        <!-- <a href="/dinas/index.php" target="blank" class="nav_link">
          <i class='bx bx-home-alt-2 nav_icon'></i>
          <span class="nav_name">Homepage</span>
        </a> -->
        <a href="dashboard.php" class="nav_link <?php if($active == 'dashboard') echo 'active' ?>">
          <i class="bx bx-grid-alt nav_icon" data-bs-toggle="tooltip" data-bs-placement="right" title="Dashboard"></i>
          <span class="nav_name">Dashboard</span> 
        </a>
        <a href="users.php" class="nav_link <?php if($active == 'users') echo 'active' ?>">
          <i class="bx bx-user nav_icon" data-bs-toggle="tooltip" data-bs-placement="right" title="Users"></i>
          <span class="nav_name">Users</span>
        </a>
        <a href="menu.php" class="nav_link <?php if($active == 'menu') echo 'active' ?>">
          <i class="bx bx-food-menu nav_icon" data-bs-toggle="tooltip" data-bs-placement="right" title="Menu items"></i>
          <span class="nav_name">Menu items</span>
        </a>
        <a href="reservations.php" class="nav_link <?php if($active == 'reservations') echo 'active' ?>">
          <i class="bx bx-bookmark nav_icon" data-bs-toggle="tooltip" data-bs-placement="right" title="Reservations"></i>
          <span class="nav_name">Reservations</span>
        </a>
        <a href="orders.php" class="nav_link <?php if($active == 'orders') echo 'active' ?>">
          <i class="bx bx-cart nav_icon" data-bs-toggle="tooltip" data-bs-placement="right" title="Orders"></i>
          <span class="nav_name">Orders</span>
        </a>
        <a href="reviews.php" class="nav_link <?php if($active == 'reviews') echo 'active' ?>">
          <i class="bx bx-message-detail nav_icon" data-bs-toggle="tooltip" data-bs-placement="right" title="Reviews"></i>
          <span class="nav_name">Reviews</span>
        </a>
      </div>
      <a href="includes/logout.php" class="nav_link">
        <i class="bx bx-log-out nav_icon" data-bs-toggle="tooltip" data-bs-placement="right" title="Sign Out"></i>
        <span class="nav_name">SignOut</span>
      </a>
    </nav>
  </div>