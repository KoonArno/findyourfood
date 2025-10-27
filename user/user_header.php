<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Find Your Food</title>
    <!-- Bootstrap 5.3.2 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Link to the external CSS file -->
    <link href="header-styles.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light navbar-custom">
        <div class="container p-4">
            <a class="navbar-brand" href="user_dashboard.php">Find Your Food</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <!-- Food Categories Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="foodDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Menu
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="foodDropdown">
                            <li class="dropdown-submenu">
                                <a class="dropdown-item dropdown-toggle" href="#">อาหาร</a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="../menus/food/a_la_carte.php">อาหารจานเดียว</a>
                                    </li>
                                    <li><a class="dropdown-item" href="../menus/food/healthy_food.php">อาหารเพื่อสุขภาพ</a></li>
                                </ul>
                            </li>

                            <li class="dropdown-submenu">
                                <a class="dropdown-item dropdown-toggle" href="#">ของหวาน</a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="../menus/dessert/Snacks.php">ของทานเล่น</a></li>
                                    <li><a class="dropdown-item" href="../menus/dessert/bakery.php">เบเกอรี่</a></li>
                                </ul>
                            </li>
                            <li class="dropdown-submenu">
                                <a class="dropdown-item dropdown-toggle" href="#">เครื่องดื่ม</a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="../menus/drink/Smoothie.php">น้ำปั่น</a></li>
                                    <li><a class="dropdown-item" href="../menus/drink/tea.php">น้ำชา</a></li>
                                    <li><a class="dropdown-item" href="../menus/drink/Soda_water.php">น้ำโซดา</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>

                    <!-- User Section -->
                    <li class="nav-item user-icon">
                        <a class="nav-link" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="bi bi-person-circle"></i>
                        </a>
                        <ul class="dropdown-menu user-dropdown" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="profile.php">จัดการข้อมูลผู้ใช้</a></li>
                            <li><a class="dropdown-item" href="Add_a_recipe.php">เพิ่มสูตรอาหาร</a></li>
                            <li><a class="dropdown-item" href="your_recipe.php">สูตรอาหารของคุณ</a></li>
                            <li><a class="dropdown-item" href="../logout.php">ออกจากระบบ</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Bootstrap 5.3.2 JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>