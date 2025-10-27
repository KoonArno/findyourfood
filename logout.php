<?php
session_start();

// ทำลายเซสชัน
session_unset();
session_destroy();

// เปลี่ยนเส้นทางไปยังหน้า Login หรือหน้าหลัก
header("Location: index.php");
exit();
?>
