<?php
// menus/list_by_type.php
// ใช้เป็นแม่แบบแสดงรายการเมนูตาม type_id
// ตัวเรียก (wrapper) ต้องตั้งค่า $PAGE = ['title' => '...', 'type_id' => '...'];

require_once(__DIR__ . '/common.php');

fyf_guard(); // ✅ เช็คสิทธิ์ก่อนส่ง output

$title  = isset($PAGE['title'])   ? $PAGE['title']   : 'เมนู';
$typeId = isset($PAGE['type_id']) ? $PAGE['type_id'] : null;

// เปิด error เฉพาะช่วงดีบัก (ค่อยปิดทีหลัง)
ini_set('display_errors', 1);
error_reporting(E_ALL);

try {
    $foods = fyf_fetch_items($conn, $typeId, 48);
} catch (Throwable $e) {
    $foods = [];
    $db_error = $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo htmlspecialchars($title); ?></title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <link href="<?php echo ROOT_PATH; ?>menus/main-styles.css" rel="stylesheet">
  <link href="<?php echo ROOT_PATH; ?>menus/mheader-styles.css" rel="stylesheet">

  <style>
    body { background: linear-gradient(#fbd3e9,#fbd3e9,#f7e1c2); min-height: 100vh; }
    .card img { object-fit: cover; height: 180px; }
  </style>
</head>
<body>

<?php include(__DIR__ . '/menu_header.php'); ?>

<div class="container mt-4 pb-5">
  <h2 class="mb-4"><?php echo htmlspecialchars($title); ?></h2>

  <?php if (!empty($db_error)): ?>
    <div class="alert alert-danger">Database error: <?php echo htmlspecialchars($db_error); ?></div>
  <?php endif; ?>

  <?php if (count($foods) === 0): ?>
    <p class="text-muted">
      <?php echo $typeId
        ? 'ยังไม่มีเมนูที่ได้รับการอนุมัติสำหรับประเภทนี้'
        : 'ยังไม่มีเมนูที่ได้รับการอนุมัติ'; ?>
      <br> (ปรับค่า <code>$PAGE['type_id']</code> ให้ตรงกับ type_id ในฐานข้อมูล ถ้าไม่แน่ใจให้ปล่อยว่างเพื่อดูทั้งหมด)
    </p>
  <?php else: ?>
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
      <?php foreach ($foods as $row): ?>
        <?php
          $imgFile = isset($row['image']) ? $row['image'] : '';
          $imgUrl  = IMG_BASE_URL . $imgFile;
        ?>
        <div class="col">
          <div class="card h-100 shadow-sm">
            <img src="<?php echo htmlspecialchars($imgUrl); ?>"
                 class="card-img-top"
                 alt="<?php echo htmlspecialchars($row['Foodname']); ?>"
                 onerror="this.src='<?php echo IMG_BASE_URL; ?>no-image.png'">
            <div class="card-body d-flex flex-column">
              <h5 class="card-title"><?php echo htmlspecialchars($row['Foodname']); ?></h5>
              <p class="card-text text-truncate"><?php echo htmlspecialchars($row['Ingredient']); ?></p>

              <button class="btn btn-outline-primary mt-auto"
                      data-bs-toggle="modal" data-bs-target="#foodModal"
                      data-name="<?php echo htmlspecialchars($row['Foodname']); ?>"
                      data-ingredients="<?php echo htmlspecialchars($row['Ingredient']); ?>"
                      data-instructions="<?php echo htmlspecialchars($row['details']); ?>"
                      data-image="<?php echo htmlspecialchars($imgUrl); ?>"
                      data-username="<?php echo htmlspecialchars($row['username']); ?>">
                ดูรายละเอียด
              </button>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</div>

<!-- Modal -->
<div class="modal fade" id="foodModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">รายละเอียดเมนู</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body"></div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
  var foodModal = document.getElementById('foodModal');
  foodModal.addEventListener('show.bs.modal', function (event) {
    var b = event.relatedTarget;
    var name = b.getAttribute('data-name');
    var ingredients = b.getAttribute('data-ingredients');
    var instructions = b.getAttribute('data-instructions');
    var image = b.getAttribute('data-image');
    var username = b.getAttribute('data-username');

    foodModal.querySelector('.modal-body').innerHTML = `
      <div class="row">
        <div class="col-md-6">
          <img src="${image}" class="img-fluid mb-3" alt="${name}">
        </div>
        <div class="col-md-6">
          <h4>${name}</h4>
          <h5>วัตถุดิบ</h5>
          <p>${ingredients}</p>
          <h5>วิธีทำ</h5>
          <p>${instructions}</p>
          <h6 class="text-muted">โดย ${username}</h6>
        </div>
      </div>`;
  });
});
</script>
</body>
</html>
