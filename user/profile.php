<?php
session_start();
include '../db.php';

if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT username, email FROM users WHERE user_id = :user_id";
$stmt = $conn->prepare($sql);
$stmt->execute(['user_id' => $user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="profile.css">
    <title>โปรไฟล์ผู้ใช้</title>
</head>
<body>
    <div class="profile-container">
        <div class="main-content">
            <h1 class="profile-heading">โปรไฟล์ของคุณ</h1>
            <div class="user-info">
                <span class="form-label">ชื่อผู้ใช้:</span>
                <span><?= htmlspecialchars($user['username']); ?></span>
            </div>
            <div class="user-info">
                <span class="form-label">อีเมล:</span>
                <span><?= htmlspecialchars($user['email']); ?></span>
            </div>

            <h2 class="profile-heading">แก้ไขโปรไฟล์</h2>
            <form action="update_profile.php" method="POST">
                <div class="form-group">
                    <label for="username" class="form-label">ชื่อผู้ใช้:</label>
                    <input type="text" id="username" name="username" class="form-control" value="<?= htmlspecialchars($user['username']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="email" class="form-label">อีเมล:</label>
                    <input type="email" id="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']); ?>" required>
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-save">ยืนยัน</button>
                    <a href="user_dashboard.php" class="btn btn-secondary" style="margin-left: 10px;">ยกเลิก</a>
                </div>
            </form>
        </div>
    </div>

    <div class="success-popup" id="successPopup">
        <div class="popup-content">
            <span class="checkmark">✓</span>
            <p>บันทึกข้อมูลเรียบร้อยแล้ว</p>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>