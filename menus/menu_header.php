<?php
// menus/menu_header.php (NAV-ONLY)
if (!defined('ROOT_PATH')) define('ROOT_PATH', '/findyourfood/');
?>
<nav class="navbar navbar-expand-lg navbar-light navbar-custom">
  <div class="container p-4">
    <a class="navbar-brand" href="<?php echo ROOT_PATH; ?>user/user_dashboard.php">Find Your Food</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Menu</a>
          <ul class="dropdown-menu">
            <li class="dropdown-submenu">
              <a class="dropdown-item dropdown-toggle" href="#">อาหาร</a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="<?php echo ROOT_PATH; ?>menus/food/a_la_carte.php">อาหารจานเดียว</a></li>
                <li><a class="dropdown-item" href="<?php echo ROOT_PATH; ?>menus/food/healthy_food.php">อาหารเพื่อสุขภาพ</a></li>
              </ul>
            </li>
            <li class="dropdown-submenu">
              <a class="dropdown-item dropdown-toggle" href="#">ของหวาน</a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="<?php echo ROOT_PATH; ?>menus/dessert/bakery.php">เบเกอรี่</a></li>
                <li><a class="dropdown-item" href="<?php echo ROOT_PATH; ?>menus/dessert/Snacks.php">ของว่าง</a></li>
              </ul>
            </li>
            <li class="dropdown-submenu">
              <a class="dropdown-item dropdown-toggle" href="#">เครื่องดื่ม</a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="<?php echo ROOT_PATH; ?>menus/drink/Smoothie.php">น้ำปั่น</a></li>
                <li><a class="dropdown-item" href="<?php echo ROOT_PATH; ?>menus/drink/tea.php">น้ำชา</a></li>
                <li><a class="dropdown-item" href="<?php echo ROOT_PATH; ?>menus/drink/Soda_water.php">น้ำโซดา</a></li>
              </ul>
            </li>
          </ul>
        </li>

        <li class="nav-item user-icon dropdown">
          <a class="nav-link" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
            <i class="bi bi-person-circle"></i>
          </a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="<?php echo ROOT_PATH; ?>login.php">Login</a></li>
            <li><a class="dropdown-item" href="<?php echo ROOT_PATH; ?>logout.php">Logout</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
