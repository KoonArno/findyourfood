<?php
session_start();
include '../db.php'; // เชื่อมต่อฐานข้อมูล

// ตรวจสอบการเข้าสู่ระบบ
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'user') {
    header('Location: ../login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// ตรวจสอบการคลิกปุ่ม (แสดงเฉพาะสถานะ 'pending', 'approved', หรือ 'rejected')
if (isset($_GET['status']) && in_array($_GET['status'], ['pending', 'approved', 'rejected'])) {
    $filter_status = $_GET['status'];
} else {
    $filter_status = 'pending'; // ค่าเริ่มต้นเป็น pending
}

// ดึงข้อมูลสูตรอาหารจากตาราง food
$stmt = $conn->prepare("SELECT * FROM Food WHERE user_id = ? AND status = ?");
$stmt->execute([$user_id, $filter_status]);
$recipes = $stmt->fetchAll();

// ส่วน HTML เริ่มที่นี่
include 'user_header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Recipes</title>
    <!-- Bootstrap 5.3.2 CDN -->
    <link rel="stylesheet" href="user-styles.css"></head>
    <style>
        .description-column {
            width: 35%;
        }
        .actions-column {
            width: 15%;
        }
        .success-popup {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }
        .popup-content {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        }
        .popup-content .checkmark {
            font-size: 50px;
            color: #4caf50;
            animation: pop 0.3s ease-in-out;
        }
        @keyframes pop {
            0% { transform: scale(0); }
            100% { transform: scale(1); }
        }
    </style>
<body>
    <div class="container mt-5">
        <h1>Your Recipes</h1>
        <?php
        if (isset($_GET['success']) && $_GET['success'] == '1') {
            echo "<div class='alert alert-success'>เพิ่มสูตรอาหารใหม่เรียบร้อยแล้ว กำลังรอการอนุมัติ</div>";
        }
        ?>
        <!-- ปุ่มแสดงสถานะสูตรอาหาร -->
        <div class="mb-3">
            <a href="your_recipe.php?status=pending" class="btn btn-warning">รอการอนุมัติ</a>
            <a href="your_recipe.php?status=approved" class="btn btn-success">อนุมัติแล้ว</a>
            <a href="your_recipe.php?status=rejected" class="btn btn-danger">ถูกปฏิเสธ</a>
        </div>
        <!-- แสดงรายการสูตรอาหาร -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Food ID</th>
                    <th>Food Name</th>
                    <th>Ingredient</th>
                    <th>Type</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($recipes as $recipe): ?>
                    <tr>
                        <td><?= htmlspecialchars($recipe['FoodId']) ?></td>
                        <td><?= htmlspecialchars($recipe['Foodname']) ?></td>
                        <td><?= htmlspecialchars(substr($recipe['Ingredient'], 0, 50)) ?>...</td>
                        <td><?= htmlspecialchars($recipe['type_id']) ?></td>
                        <td>
                            <a href="delete_recipe.php?id=<?= $recipe['FoodId'] ?>" class="btn btn-danger" onclick="return confirm('คุณแน่ใจหรือไม่ที่จะลบสูตรอาหารนี้?')">ลบ</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <?php if (isset($_GET['status']) && $_GET['status'] === 'success'): ?>
        <div class="success-popup" id="successPopup">
            <div class="popup-content">
                <div class="checkmark">✔</div>
                <p>ลบรายการอาหารเรียบร้อยแล้ว</p>
                <button class="btn btn-primary" onclick="closePopup()">ปิด</button>
            </div>
        </div>
        <script>
            function closePopup() {
                document.getElementById('successPopup').style.display = 'none';
                window.location.href = 'your_recipe.php';
            }
        </script>
    <?php endif; ?>
    <!-- Bootstrap JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>