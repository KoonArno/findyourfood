<?php
// เริ่มต้น session
session_start();
// น าเข ้าไฟล์ admin_header.php
include 'admin_header.php';
// น าเขา้ไฟลท์ เี่ ชอื่ มตอ่ กับฐานขอ้มลู
include '../db.php';

// ตรวจสอบวา่ มขี อ้ ความส าเร็จใน session หรือไม่
if (isset($_SESSION['success_message'])) {
    echo "<div class='alert alert-success'>" . $_SESSION['success_message'] . "</div>";
    // ลบข ้อความหลังจากแสดง
    unset($_SESSION['success_message']);
}
// ตรวจสอบวา่ มกี ารสง่ ค าคน้ หาหรอื ไม่
$searchQuery = "";
if (isset($_GET['search'])) {
    $searchQuery = $_GET['search'];
    // ดึงข ้อมูล Users โดยกรองตามค าค้นหา
    $sql = "SELECT * FROM users WHERE user_id LIKE ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute(["%$searchQuery%"]);
    $result = $stmt;
} else {
    // ดึงข ้อมูล Users ทั้งหมด
    $sql = "SELECT * FROM users";
    $sql = "SELECT users.user_id, users.username, users.email, users.role ,users.created_at FROM users";
    $result = $conn->query($sql);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
            0% {
                transform: scale(0);
            }

            100% {
                transform: scale(1);
            }
        }
    </style>
</head>

<body>
    <div class="container mt-4">
        <h1 class="text-center">Manage Users</h1>
        <!-- ฟอร์มค้นหา -->
        <form method="GET" action="" class="mb-4">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search by Username"
                    value="<?= htmlspecialchars($searchQuery) ?>">

                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </form>

        <!-- ตารางแสดงขอ้ มลู ผใู้ช ้-->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch()): ?>
                    <tr>
                        <td><?php echo $row['user_id']; ?></td>
                        <td><?php echo htmlspecialchars($row['username']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['role']); ?></td>
                        <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                        <td>
                            <a href="delete_user.php?id=<?php echo $row['user_id']; ?>" class="btn btn-danger"
                                onclick="return confirm('คุณแน่ใจหรือไม่ว่าต้องการลบ?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <?php if (isset($_GET['status']) && $_GET['status'] === 'success'): ?>
        <div class="success-popup" id="successPopup">
            <div class="popup-content">
                <div class="checkmark">✔</div>
                <p>ลบผู้ใช้เรียบร้อยแล้ว</p>
                <button class="btn btn-primary" onclick="closePopup()">ปิด</button>
            </div>
        </div>
        <script>
            function closePopup() {
                document.getElementById('successPopup').style.display = 'none';
                window.location.href = 'manage_user.php';
            }
        </script>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</body>

</html>