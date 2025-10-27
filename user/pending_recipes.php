<?php
session_start();
include '../db.php';

if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}

try {
    $username = $_SESSION['username'];
    $sql = "SELECT * FROM Food WHERE status = 'pending' AND user_id = (SELECT id FROM users WHERE username = :username)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $pending_recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$conn = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>สูตรอาหารที่รอการอนุมัติ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">สูตรอาหารที่รอการอนุมัติ</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ชื่ออาหาร</th>
                    <th>วันที่เพิ่ม</th>
                    <th>สถานะ</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pending_recipes as $recipe): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($recipe['Foodname']); ?></td>
                        <td><?php echo htmlspecialchars($recipe['created_at']); ?></td>
                        <td>
                            <?php if ($recipe['status'] == 'pending'): ?>
                                <span class="badge bg-warning">รอการอนุมัติ</span>
                            <?php elseif ($recipe['status'] == 'approved'): ?>
                                <span class="badge bg-success">อนุมัติแล้ว</span>
                            <?php else: ?>
                                <span class="badge bg-danger">ไม่อนุมัติ</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="user_dashboard.php" class="btn btn-primary">กลับสู่หน้าหลัก</a>
    </div>
</body>
</html>