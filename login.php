<?php
// เริ่ม session
session_start();

// เชื่อมต่อฐานข้อมูล
include('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // รับข้อมูลจากฟอร์ม
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        // ตรวจสอบว่าผู้ใช้มีอยู่ในฐานข้อมูลหรือไม่
        $sql = "SELECT * FROM users WHERE username = :username";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch();

        if ($user) {
            // ตรวจสอบรหัสผ่าน
            if (password_verify($password, $user['password'])) {
                // เก็บข้อมูลลงใน session
                $_SESSION['username'] = $username;
                $_SESSION['user_id'] = $user['user_id']; // เก็บ user_id ลงใน session
                $_SESSION['role'] = $user['role']; // เก็บ role ลงใน session

                // ตรวจสอบ role และเปลี่ยนเส้นทางตามความเหมาะสม
                if ($user['role'] === 'admin') {
                    header('Location: admin/admin_dashboard.php');
                } else {
                    header('Location: user/user_dashboard.php');
                }
                exit();
            } else {
                // แจ้งเตือนว่ารหัสผ่านไม่ถูกต้อง
                echo "<script>alert('Password is incorrect.');</script>";
            }
        } else {
            // แจ้งเตือนว่าชื่อผู้ใช้ไม่ถูกต้อง
            echo "<script>alert('Username not found.');</script>";
        }
    } catch (PDOException $e) {
        // จัดการกับข้อผิดพลาดในการเชื่อมต่อฐานข้อมูล
        echo "Error: " . $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login-styles.css"> <!-- เชื่อมต่อกับไฟล์ CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet"> <!-- เพิ่มการใช้งาน Bootstrap Icons -->
</head>

<body>
    <div class="login-container">
        <div class="login-icon"></div>
        <h2>Login</h2>
        <form method="POST" action="">
            <input type="text" name="username" placeholder="Username..." required>
            <div class="password-container">
                <input type="password" name="password" placeholder="Password..." required id="passwordInput">
                <span class="toggle-password" onclick="togglePassword()">
                    <i class="bi bi-eye" id="eyeIcon"></i>
                </span>
            </div>
            <input type="submit" value="Sign in">
        </form>
        <a href="register.php" class="forgot-password">Don't have an account? Register here</a>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('passwordInput');
            const eyeIcon = document.getElementById('eyeIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text'; // แสดงรหัสผ่าน
                eyeIcon.classList.remove('bi-eye'); // เปลี่ยนเป็นไอคอนตาที่เปิด
                eyeIcon.classList.add('bi-eye-slash'); // ใช้ไอคอนตาที่ปิด
            } else {
                passwordInput.type = 'password'; // ซ่อนรหัสผ่าน
                eyeIcon.classList.remove('bi-eye-slash'); // เปลี่ยนกลับเป็นไอคอนตาที่เปิด
                eyeIcon.classList.add('bi-eye'); // ใช้ไอคอนตาที่ปิด
            }
        }
    </script>
</body>

</html>
