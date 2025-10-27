<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>หน้าเกี่ยวกับเรา</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body, html {
      height: 100%;
      margin: 0;
    }

    .content {
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    .main-content {
      flex: 1;
    }

        footer {
      position: absolute;
      bottom: 0;
      width: 100%;
      background-image: linear-gradient(to right, #FFF0E5, #FFD1DC) !important;
      color: black; /* ตัวอักษรสีดำ */
        }

        footer a {
      color: white; /* เปลี่ยนสีลิงก์ใน footer */
        }

        footer a:hover {
      color: #f8f9fa; /* เปลี่ยนสีลิงก์เมื่อ hover */
        }
    </style>
</head>

<body>

  <div class="content">
    <div class="main-content">
      <!-- เนื้อหาของหน้าคุณวางตรงนี้ -->
    </div>

    <footer class="text-center text-lg-start mt-4">
        <div class="container p-4">
            <div class="row">
                <div class="col-lg-6 col-md-12 mb-4 mb-md-0">
                    <h5 class="text-uppercase">Find Your Food</h5>
                </div>

                <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                    <h5 class="text-uppercase">Links</h5>
                    <ul class="list-unstyled mb-0">
              <li><a href="../about_us.php" class="text-dark">เกี่ยวกับเรา</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                    <h5 class="text-uppercase">Follow Us</h5>
                    <ul class="list-unstyled mb-0">
                        <li><a href="https://www.facebook.com/" class="text-dark">Facebook</a></li>
                        <li><a href="https://www.youtube.com/" class="text-dark">YouTube</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
  </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
