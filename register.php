<?php
// เริ่ม session
session_start();

// เชื่อมต่อฐานข้อมูล
include('db.php');

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $conn = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    throw new PDOException($e->getMessage(), (int) $e->getCode());
}

// ตรวจสอบการส่งข้อมูลจากฟอร์ม
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // แฮชรหัสผ่าน
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // เพิ่มข้อมูลผู้ใช้ลงในฐานข้อมูล
    try {
        $sql = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['username' => $username, 'email' => $email, 'password' => $hashed_password]);

        // เปลี่ยนเส้นทางไปยังหน้าความสำเร็จ
        header("Location: registration_success.php");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="login-styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <div class="login-container">
        <div class="login-icon"></div>
        <h2>Register</h2>
        <form method="POST" action="" onsubmit="return validatePasswords()">
            <input type="text" name="username" placeholder="Username..." required>
            <input type="email" name="email" placeholder="Email..." required>
            <div class="password-container">
                <input type="password" name="password" placeholder="Password..." required id="passwordInput">
                <span class="toggle-password" onclick="togglePassword('passwordInput', 'eyeIcon1')">
                    <i class="bi bi-eye" id="eyeIcon1"></i>
                </span>
            </div>
            <div class="password-container">
                <input type="password" name="confirm_password" placeholder="Confirm Password..." required id="confirmPasswordInput">
                <span class="toggle-password" onclick="togglePassword('confirmPasswordInput', 'eyeIcon2')">
                    <i class="bi bi-eye" id="eyeIcon2"></i>
                </span>
            </div>
            <input type="submit" value="Register">
        </form>
        <a href="login.php" class="forgot-password">Already have an account? Login here</a>
    </div>

    <script>
        function togglePassword(inputId, iconId) {
            const passwordInput = document.getElementById(inputId);
            const eyeIcon = document.getElementById(iconId);

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

        function validatePasswords() {
            const password = document.getElementById('passwordInput').value;
            const confirmPassword = document.getElementById('confirmPasswordInput').value;

            if (password !== confirmPassword) {
                alert("Passwords do not match."); // แสดงการแจ้งเตือน
                return false; // ป้องกันการส่งฟอร์ม
            }
            return true; // ส่งฟอร์ม
        }
    </script>
</body>
</html>
