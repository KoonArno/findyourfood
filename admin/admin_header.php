<?php
// เชื่อมต่อกับฐานข้อมูล
include('../db.php');
// ตรวจสอบว่ามีการล็อกอินหรือไม่
if (!isset($_SESSION['username'])) {
    // ถ้าไม่มีการล็อกอิน ให้เปลี่ยนเส้นทางไปยังหน้า login
    header("Location: login.php");
    exit();

}
// ตรวจสอบบทบาทของผู้ใช้
$username = $_SESSION['username'];
$sql = "SELECT role FROM users WHERE username = :username";
$stmt = $conn->prepare($sql);
$stmt->execute(['username' => $username]);
$user = $stmt->fetch();

if ($user && $user['role'] == 'admin') {
    // ถ้าเป็น admin ให้อนุญาตการเข้าถึงหน้า admin ทั้งหมด
    $allowed_pages = ['admin_dashboard.php', 'manage_recipe.php', 'manage_user.php','approve.php',];
    $current_page = basename($_SERVER['PHP_SELF']);
    
    if (!in_array($current_page, $allowed_pages)) {
        header("Location: /admin/admin_dashboard.php");
        exit();
    }
} else {
    // ถ้าไม่ใช่ admin ให้เปลี่ยนเส้นทางไปยังหน้า index.php
    header("Location: /index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <!-- Navbar ส าหรับ Admin -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="admin_dashboard.php">Admin Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="manage_recipe.php">Manage Recipe</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="manage_user.php">Manage Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="approve.php">Approve</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</body>
</html>