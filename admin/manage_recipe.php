<?php
// เริ่มต้น session
session_start();
require 'admin_header.php';
include '../db.php';

// ตรวจสอบว่ามีข้อความส าเร็จใน session หรือไม่
if (isset($_SESSION['success_message'])) {
    echo "<div class='alert alert-success'>" . $_SESSION['success_message'] . "</div>";
    unset($_SESSION['success_message']);
}

// ตรวจสอบว่ามีการส่งค าค้นหาหรือไม่
$searchQuery = "";
$result = null;  // กำหนดค่าเริ่มต้นให้กับตัวแปร $result เพื่อป้องกันการเกิด Warning

try {
    if (isset($_GET['search'])) {
        $searchQuery = $_GET['search'];
        // ดึงข้อมูล recipes โดยกรองตามค าค้นหา
        $sql = "SELECT food.*, type.type_name FROM food JOIN type ON food.type_id = type.type_id WHERE Foodname LIKE ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute(["%$searchQuery%"]);
        $result = $stmt;
    } else {
        // ดึงข้อมูล recipes ทั้งหมด
        $sql = "SELECT food.*, type.type_name FROM food JOIN type ON food.type_id = type.type_id";
        $result = $conn->query($sql);
    }
} catch (Exception $e) {
    echo "<div class='alert alert-danger'>เกิดข้อผิดพลาด: " . $e->getMessage() . "</div>";
}
?>

<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Recipes</title>
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
        <h1 class="text-center">Manage Recipes</h1>
        <form method="GET" action="" class="mb-4">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search by recipe name"
                    value="<?= htmlspecialchars($searchQuery) ?>">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </form>
        <div class="text-end mb-3">
            <a href="Add_a_recipe.php" class="btn btn-success">Add Recipe</a>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Ingredients</th>
                    <th>Instructions</th>
                    <th>Type</th> <!-- คอลัมน์ที่เพิ่มเข้ามา -->
                    <th>Created At</th>
                    <th class="actions-column">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch()): ?>
                    <tr>
                        <td><?php echo $row['FoodId']; ?></td>
                        <td><?php echo htmlspecialchars($row['Foodname']); ?></td>
                        <td>
                            <?php if ($row['image']): ?>
                                <img src="../img/<?php echo htmlspecialchars($row['image']); ?>" width="50">
                            <?php endif; ?>
                        </td>
                        <td><?php echo htmlspecialchars($row['Ingredient']); ?></td>
                        <td><?php echo htmlspecialchars($row['details']); ?></td>
                        <td><?php echo htmlspecialchars($row['type_name']); ?></td> <!-- แสดงชื่อประเภทอาหาร -->
                        <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                        <td>
                            <a href="edit.recipe.php?id=<?php echo $row['FoodId']; ?>" class="btn btn-warning">Edit</a>
                            <a href="delete_recipe.php?id=<?php echo $row['FoodId']; ?>" class="btn btn-danger"
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
                <p>ลบรายการอาหารเรียบร้อยแล้ว</p>
                <button class="btn btn-primary" onclick="closePopup()">ปิด</button>
            </div>
        </div>
        <script>
            function closePopup() {
                document.getElementById('successPopup').style.display = 'none';
                window.location.href = 'manage_recipe.php';
            }
        </script>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>