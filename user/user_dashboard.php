<?php
session_start();
include('../db.php');

define('IMG_BASE_URL', '../img/');

// ตรวจสอบการเข้าสู่ระบบ
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$searchResult = null;
$errorMessage = '';

// ตรวจสอบว่ามีการส่งคำค้นหาหรือไม่
if (isset($_POST['search'])) {
    $searchTerm = $_POST['search'];

    // ค้นหาข้อมูลจากตาราง Food
    $query = "SELECT food.*, users.username FROM food 
             INNER JOIN users ON food.user_id = users.user_id 
             WHERE Foodname = :searchTerm";

    // เตรียมคำสั่ง SQL และป้องกัน SQL injection
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':searchTerm', $searchTerm, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $searchResult = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        $errorMessage = "ไม่พบข้อมูลที่ค้นหา";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Find Your Food</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="user-styles.css">
    <link rel="stylesheet" href="modal-styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <?php include 'user_header.php'; ?>
    <div class="hero">
        <div class="hero-content">
            <h1 class="text-shadow">LIFE FOR EATING</h1>
            <form method="POST" action="">
                <div class="search-box">
                    <input type="text" name="search" placeholder="Search for food...">
                    <button type="submit">SEARCH</button>
                </div>
            </form>
        </div>
        <div class="hero-image">
            <img src="Png1.png" alt="Delicious Burger">
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="foodDetailModal" tabindex="-1" aria-labelledby="foodDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="foodDetailModalLabel">รายละเอียดอาหาร</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php if ($searchResult): ?>
                    <div class="row">
                        <div class="col-md-6">
                            <img src="<?php echo IMG_BASE_URL . htmlspecialchars($searchResult['image']); ?>" 
                                 class="img-fluid mb-3" 
                                 alt="<?php echo htmlspecialchars($searchResult['Foodname']); ?>">
                        </div>
                        <div class="col-md-6">
                            <h4><?php echo htmlspecialchars($searchResult['Foodname']); ?></h4>
                            <h5>วัตถุดิบ:</h5>
                            <p><?php echo nl2br(htmlspecialchars($searchResult['Ingredient'])); ?></p>
                            <h5>วิธีการทำ:</h5>
                            <p><?php echo nl2br(htmlspecialchars($searchResult['details'])); ?></p>
                            <h5>เขียนโดย:</h5>
                            <p><?php echo htmlspecialchars($searchResult['username']); ?></p>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <?php
    include '../partials/footer.php'; // เรยี กใชส้ ว่ นทา้ยมารวม
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            <?php if ($searchResult): ?>
            $('#foodDetailModal').modal('show');
            <?php endif; ?>

            <?php if ($errorMessage): ?>
            alert("<?php echo $errorMessage; ?>");
            <?php endif; ?>
        });
    </script>
</body>
</html>