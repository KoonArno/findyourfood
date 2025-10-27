<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>หน้าเกี่ยวกับเรา</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh; /* ทำให้ body มีความสูงอย่างน้อย 100vh */
        }

        .modal-content {
            border-radius: 10px;
        }

        .about-us {
            padding: 20px;
            background-color: #f8f9fa; /* เปลี่ยนสีพื้นหลังได้ตามต้องการ */
        }

        .about-us h1 {
            color: #333; /* เปลี่ยนสีตัวอักษรหัวข้อ */
        }

        .about-us p {
            margin-bottom: 15px; /* เว้นระยะห่างระหว่างย่อหน้า */
            font-size: 1.1rem; /* ปรับขนาดฟอนต์ของข้อความ */
            line-height: 1.6; /* เพิ่มระยะห่างระหว่างบรรทัด */
        }

        /* เพิ่มสไตล์สำหรับข้อความต้อนรับ */
        .welcome-text {
            text-align: center; /* จัดให้อยู่ตรงกลาง */
            font-size: 2.5rem; /* ปรับขนาดฟอนต์ */
            margin-top: 50px; /* เว้นระยะห่างด้านบน */
            margin-bottom: 20px; /* เว้นระยะห่างด้านล่าง */
        }

        /* เพิ่มสไตล์สำหรับ footer */
        footer {
            background-color: #f8f9fa; /* เปลี่ยนสีพื้นหลังของ footer */
            padding: 20px 0; /* เพิ่ม padding ด้านบนและด้านล่าง */
            text-align: center; /* จัดข้อความให้อยู่ตรงกลาง */
            margin-top: auto; /* ผลัก footer ลงไปอยู่ด้านล่างสุด */
        }
    </style>
</head>

<body>

    <?php include './partials/header.php'; // เรียกใช้งานส่วนหัว ?>

    <div class="container mt-5 text-center flex-grow-1"> <!-- เพิ่ม class flex-grow-1 เพื่อให้ container เติบโตเต็มที่ -->
        <h1 class="welcome-text">ยินดีต้อนรับสู่เว็บไซต์ของเรา!</h1>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#aboutModal">
            เกี่ยวกับเรา
        </button>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="aboutModal" tabindex="-1" aria-labelledby="aboutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl"> <!-- เปลี่ยนขนาดเป็น modal-xl -->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="aboutModalLabel">เกี่ยวกับเรา</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body about-us">
                    <h1>เกี่ยวกับเรา</h1>
                    <p>ยินดีต้อนรับสู่ <strong>Find Your Food</strong> เว็บไซต์ที่มุ่งมั่นที่จะเป็นแหล่งข้อมูลและบริการที่ครบครันเกี่ยวกับอาหารของคุณ! เราเข้าใจดีว่าอาหารไม่ได้เป็นเพียงแค่การบริโภค แต่ยังเป็นประสบการณ์ที่เต็มไปด้วยความสุขและความทรงจำที่ดี นั่นคือเหตุผลที่เราได้สร้างแพลตฟอร์มนี้ขึ้นมา เพื่อช่วยให้คุณค้นพบสิ่งที่ดีที่สุดในโลกของอาหาร</p>

                    <p>ภารกิจของเราคือการให้ข้อมูลที่ถูกต้องและเป็นประโยชน์เกี่ยวกับอาหาร ไม่ว่าจะเป็นสูตรอาหารที่แสนอร่อย เคล็ดลับการทำอาหาร รีวิวร้านอาหาร และบทความที่น่าสนใจเกี่ยวกับวัฒนธรรมการกินในหลากหลายประเทศ เรามีความตั้งใจที่จะเป็นเพื่อนคู่คิดของคุณในการสร้างสรรค์มื้ออาหารที่น่าจดจำและสุขภาพดี</p>

                    <p>เราเป็นทีมงานที่มีความหลงใหลในอาหารและการทำอาหาร พวกเราเป็นนักเขียน นักชิม และผู้เชี่ยวชาญด้านอาหารที่พร้อมที่จะนำเสนอข้อมูลที่มีคุณภาพและเชื่อถือได้ ทีมงานของเราทุกคนมีประสบการณ์ในวงการอาหารและมีความตั้งใจที่จะสร้างสรรค์เนื้อหาที่ดีที่สุดสำหรับผู้ใช้งานของเรา</p>

                    <p>ขอบคุณที่เลือก Find Your Food เป็นคู่มือในการเดินทางสู่โลกของอาหาร! เราหวังว่าจะได้ช่วยให้คุณค้นพบอาหารที่คุณรักและสร้างประสบการณ์การกินที่ดีที่สุด</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                </div>
            </div>
        </div>
    </div>

    <?php include './partials/footer.php'; // เรียกใช้งานส่วนท้าย ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>