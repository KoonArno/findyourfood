<?php
// เริ่มต้น session
session_start();
include '../db.php'; // นำเข้าไฟล์เชื่อมต่อฐานข้อมูล

// ตรวจสอบว่ามีการส่ง recipe_id มาหรือไม่
if (!isset($_GET['id'])) {
    echo "ไม่พบสูตรอาหารที่ต้องการแก้ไข";
    exit();
}
$recipe_id = $_GET['id'];

// ดึงข้อมูลสูตรอาหารที่ต้องการแก้ไข
$stmt = $conn->prepare("SELECT * FROM food WHERE FoodId = ?");
$stmt->execute([$recipe_id]);
$recipe = $stmt->fetch();

// ตรวจสอบว่าพบสูตรอาหารหรือไม่
if (!$recipe) {
    echo "ไม่พบสูตรอาหารที่ต้องการแก้ไข";
    exit();
}

// ดึงข้อมูลประเภทอาหาร
$typeQuery = "SELECT * FROM type";
$typeStmt = $conn->prepare($typeQuery);
$typeStmt->execute();
$types = $typeStmt->fetchAll(PDO::FETCH_ASSOC);

$success_message = "";

// ถ้าผู้ใช้ส่งข้อมูลเพื่อแก้ไข
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $ingredients = $_POST['ingredients'];
    $details = $_POST['details'];
    $type_id = $_POST['type_id']; // รับค่า type_id

    // จัดการกับการอัพโหลดรูปภาพใหม่
    $image = $recipe['image']; // ใช้รูปภาพเดิม ถ้าไม่มีการอัปโหลดใหม่
    if (!empty($_FILES['image']['name'])) {
        $image = basename($_FILES['image']['name']);
        $target_image_path = "../images/" . $image;
        move_uploaded_file($_FILES['image']['tmp_name'], $target_image_path);
    }

    // อัปเดตข้อมูลในฐานข้อมูล
    $stmt = $conn->prepare("UPDATE food SET Foodname = ?, Ingredient = ?, details = ?, image = ?, type_id = ? WHERE FoodId = ?");
    if ($stmt->execute([$name, $ingredients, $details, $image, $type_id, $recipe_id])) {
        $success_message = "แก้ไขข้อมูลสำเร็จ";
    } else {
        echo "เกิดข้อผิดพลาดในการแก้ไขข้อมูล";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Recipe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .success-popup {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: none;
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
    <div class="container mt-5">
        <h2 class="text-center">Edit Recipe</h2>
        <form method="POST" action="" enctype="multipart/form-data" id="editRecipeForm">
            <div class="mb-3">
                <label for="name" class="form-label">ชื่ออาหาร</label>
                <input type="text" class="form-control" id="name" name="name"
                    value="<?php echo htmlspecialchars($recipe['Foodname']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="ingredients" class="form-label">ส่วนผสม</label>
                <textarea class="form-control" id="ingredients" name="ingredients"
                    required><?php echo htmlspecialchars($recipe['Ingredient']); ?></textarea>
            </div>
            <div class="mb-3">
                <label for="details" class="form-label">วิธีการทำ</label>
                <textarea class="form-control" id="details" name="details" required><?php echo htmlspecialchars($recipe['details']); ?></textarea>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                <input type="file" class="form-control" id="image" name="image">
                <?php if ($recipe['image']): ?>
                    <img src="../img/<?php echo htmlspecialchars($recipe['image']); ?>" alt="Current Image" width="100"
                        class="mt-2">
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="type_id" class="form-label">ประเภทอาหาร</label>
                <select class="form-select" id="type_id" name="type_id" required>
                    <?php foreach ($types as $type): ?>
                        <option value="<?php echo htmlspecialchars($type['type_id']); ?>" 
                            <?php if ($type['type_id'] == $recipe['type_id']) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($type['type_name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Save changes</button>
            <a href="manage_recipe.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <div class="success-popup" id="successPopup">
        <div class="popup-content">
            <div class="checkmark">✔</div>
            <p id="successMessage">แก้ไขข้อมูลสำเร็จ</p>
            <button class="btn btn-primary" onclick="closePopup()">ปิด</button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function closePopup() {
            document.getElementById('successPopup').style.display = 'none';
            window.location.href = 'manage_recipe.php';
        }

        // แสดง popup หากมีข้อความสำเร็จ
        <?php if ($success_message): ?>
            document.getElementById('successMessage').innerText = "<?php echo $success_message; ?>";
            document.getElementById('successPopup').style.display = 'flex';
        <?php endif; ?>
    </script>
</body>

</html>