<?php
session_start();
require 'admin_header.php';
include '../db.php';
// ตรวจสอบว่าผู้ใช้เป็น Admin หรือไม่
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit();
}

// ตรวจสอบการคลิกปุ่ม Approve หรือ Reject
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $food_id = $_POST['food_id']; // เปลี่ยนจาก 'FoodId' เป็น 'food_id'
    $action = $_POST['action']; // เปลี่ยนจาก 'status' เป็น 'action'

    if ($action == 'approve') {
        // อัปเดตสถานะเป็น Approved
        $stmt = $conn->prepare("UPDATE food SET status = 'approved' WHERE FoodId = ?");
        $stmt->execute([$food_id]);
        $_SESSION['success_message'] = "สูตรอาหารได้รับการอนุมัติแล้ว!";
    } elseif ($action == 'reject') {
        // อัปเดตสถานะเป็น Rejected
        $stmt = $conn->prepare("UPDATE food SET status = 'rejected' WHERE FoodId = ?");
        $stmt->execute([$food_id]);
        $_SESSION['error_message'] = "สูตรอาหารถูกปฏิเสธ!";
    }

    header('Location: approve.php');
    exit();
}

// ดึงข้อมูลสูตรอาหารที่มีสถานะเป็น pending
$stmt = $conn->prepare("SELECT food.*, users.username 
                        FROM food 
                        JOIN users ON food.user_id = users.user_id 
                        WHERE food.status = 'pending'");
$stmt->execute();
$recipes = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>อนุมัติสูตรอาหาร (Admin)</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>อนุมัติสูตรอาหาร (Admin)</h1>
        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="alert alert-success">
                <?= $_SESSION['success_message']; ?>
            </div>
            <?php unset($_SESSION['success_message']); ?>
        <?php elseif (isset($_SESSION['error_message'])): ?>
            <div class="alert alert-danger">
                <?= $_SESSION['error_message']; ?>
            </div>
            <?php unset($_SESSION['error_message']); ?>
        <?php endif; ?>
        
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>รหัสอาหาร</th>
                    <th>ชื่อผู้ใช้</th>
                    <th>ชื่ออาหาร</th>
                    <th>ส่วนผสม</th>
                    <th>วิธีทำ</th>
                    <th>รูปภาพ</th>
                    <th>ประเภทอาหาร</th>
                    <th>สถานะ</th>
                    <th>การดำเนินการ</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($recipes) > 0): ?>
                    <?php foreach ($recipes as $recipe): ?>
                        <tr>
                            <td><?= htmlspecialchars($recipe['FoodId']) ?></td>
                            <td><?= htmlspecialchars($recipe['username']) ?></td>
                            <td><?= htmlspecialchars($recipe['Foodname']) ?></td>
                            <td><?= htmlspecialchars(substr($recipe['Ingredient'], 0, 50)) ?>...</td>
                            <td><?= htmlspecialchars(substr($recipe['details'], 0, 50)) ?>...</td>
                            <td>
                                <?php if (file_exists("../img" . htmlspecialchars($recipe['image']))): ?>
                                    <a href="../img<?= htmlspecialchars($recipe['image']) ?>" target="_blank">ดูรูปภาพ</a>
                                <?php else: ?>
                                    <span>ไม่มีรูปภาพ</span>
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($recipe['type_id']) ?></td>
                            <td><?= htmlspecialchars($recipe['status']) ?></td>
                            <td>
                                <form method="POST" action="">
                                    <input type="hidden" name="food_id" value="<?= $recipe['FoodId'] ?>"> <!-- แก้จาก FoodId -->
                                    <button type="submit" name="action" value="approve" class="btn btn-success">อนุมัติ</button>
                                    <button type="submit" name="action" value="reject" class="btn btn-danger">ปฏิเสธ</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="10" class="text-center">ไม่พบสูตรอาหารที่รอการอนุมัติ</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
