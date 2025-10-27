<?php
// เริ่มต้น session
session_start();

// include database connection
include('../db.php');

// ตรวจสอบการเข้าสู่ระบบ
if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

function clean_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// ตรวจสอบว่าเป็นการส่งข้อมูลผ่าน AJAX หรือไม่
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    try {
        $Foodname = clean_input($_POST['name']);
        $Ingredient = clean_input($_POST['description']);
        $details = clean_input($_POST['details']);
        $type_id = $_POST['type_id'];

        // จัดการอัปโหลดรูปภาพ
        $image = $_FILES['image']['name'];
        $target_dir = "../img";
        $target_file = $target_dir . "/" . basename($image);

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $sql = "INSERT INTO Food (Foodname, Ingredient, details, Image, type_id, user_id, status) 
                    VALUES (:Foodname, :Ingredient, :details, :image, :type_id, :user_id, 'pending')";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':Foodname', $Foodname);
            $stmt->bindParam(':Ingredient', $Ingredient);
            $stmt->bindParam(':details', $details);
            $stmt->bindParam(':image', $image);
            $stmt->bindParam(':type_id', $type_id);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();

            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'เกิดข้อผิดพลาดในการอัปโหลดรูปภาพ']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
    exit();
}

$conn = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เพิ่มข้อมูลอาหาร</title>
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
            0% { transform: scale(0); }
            100% { transform: scale(1); }
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center">
                        <h2>เพิ่มข้อมูลอาหารใหม่</h2>
                    </div>
                    <div class="card-body">
                        <form id="recipeForm" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="name" class="form-label">ชื่ออาหาร</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">ส่วนผสม</label>
                                <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="image" class="form-label">อัปโหลดรูปภาพ</label>
                                <input type="file" class="form-control" id="image" name="image" required>
                            </div>
                            <div class="mb-3">
                                <label for="details" class="form-label">วิธีการทำ</label>
                                <textarea class="form-control" id="details" name="details" rows="4" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="type_id" class="form-label">ประเภทอาหาร</label>
                                <select class="form-select" id="type_id" name="type_id" required>
                                    <option value="T01">อาหารจานเดียว</option>
                                    <option value="T02">อาหารสุขภาพ</option>
                                    <option value="T03">ของทานเล่น</option>
                                    <option value="T04">เบเกอรี่</option>
                                    <option value="T05">น้ำปั่น</option>
                                    <option value="T06">น้ำชา</option>
                                    <option value="T07">น้ำโซดา</option>
                                </select>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">บันทึก</button>
                                <a href="user_dashboard.php" class="btn btn-secondary">ย้อนกลับ</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="success-popup" id="successPopup">
        <div class="popup-content">
            <div class="checkmark">✔</div>
            <p>เพิ่มสูตรอาหารเรียบร้อย กำลังรออนุมัติจากผู้ดูแล</p>
            <button class="btn btn-primary" onclick="closePopup()">ปิด</button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#recipeForm').on('submit', function(e) {
                e.preventDefault();
                var formData = new FormData(this);

                $.ajax({
                    url: 'Add_a_recipe.php',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        var result = JSON.parse(response);
                        if(result.success) {
                            $('#successPopup').css('display', 'flex');
                        } else {
                            alert('เกิดข้อผิดพลาด: ' + result.message);
                        }
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            });
        });

        function closePopup() {
            document.getElementById('successPopup').style.display = 'none';
            document.getElementById('recipeForm').reset();
        }
    </script>
</body>
</html>