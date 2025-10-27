<?php
// menus/common.php
// ใช้รวมฟังก์ชัน/คอนฟิกกลางทั้งหมด

// ---- Path/URL base ของโปรเจ็กต์ (ปรับถ้าโฮสต์จริงต่างไป) ----
if (!defined('ROOT_PATH'))     define('ROOT_PATH', '/findyourfood/');
if (!defined('IMG_BASE_URL'))  define('IMG_BASE_URL', ROOT_PATH . 'img/');

// ---- start session + guard ก่อนมี output ----
function fyf_guard() {
    if (session_status() === PHP_SESSION_NONE) session_start();
    if (!isset($_SESSION['username'])) {
        header('Location: ' . ROOT_PATH . 'login.php');
        exit();
    }
}

// ---- include db (จากโฟลเดอร์ menus/ เดินขึ้นไประดับเดียว) ----
require_once(__DIR__ . '/../db.php');   // ต้องให้ db.php สร้าง $conn (PDO หรือ MySQLi)

// ---- ดึงรายการเมนู (รองรับ PDO และ MySQLi) ----
function fyf_fetch_items($conn, $typeId = null, $limit = 48) {
    $rows = [];

    // แบบ PDO
    if ($conn instanceof PDO) {
        if ($typeId) {
            $sql = "SELECT f.Foodname, f.Ingredient, f.details, f.image AS image, u.username
                    FROM `food` AS f
                    INNER JOIN `users` AS u ON f.user_id = u.user_id
                    WHERE f.type_id = :tid AND f.status = 'approved'
                    ORDER BY f.Foodname ASC
                    LIMIT :lim";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':tid', $typeId, PDO::PARAM_STR);
            $stmt->bindValue(':lim', (int)$limit, PDO::PARAM_INT);
        } else {
            $sql = "SELECT f.Foodname, f.Ingredient, f.details, f.image AS image, u.username
                    FROM `food` AS f
                    INNER JOIN `users` AS u ON f.user_id = u.user_id
                    WHERE f.status = 'approved'
                    ORDER BY f.Foodname ASC
                    LIMIT :lim";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':lim', (int)$limit, PDO::PARAM_INT);
        }
        $stmt->execute();
        while ($r = $stmt->fetch(PDO::FETCH_ASSOC)) $rows[] = $r;
        return $rows;
    }

    // แบบ MySQLi
    if ($conn instanceof mysqli) {
        if ($typeId) {
            $sql = "SELECT f.Foodname, f.Ingredient, f.details, f.image AS image, u.username
                    FROM `food` AS f
                    INNER JOIN `users` AS u ON f.user_id = u.user_id
                    WHERE f.type_id = ? AND f.status = 'approved'
                    ORDER BY f.Foodname ASC
                    LIMIT ?";
            $stmt = $conn->prepare($sql);
            if (!$stmt) throw new Exception("MySQLi prepare failed: " . $conn->error);
            $stmt->bind_param('si', $typeId, $limit);
        } else {
            $sql = "SELECT f.Foodname, f.Ingredient, f.details, f.image AS image, u.username
                    FROM `food` AS f
                    INNER JOIN `users` AS u ON f.user_id = u.user_id
                    WHERE f.status = 'approved'
                    ORDER BY f.Foodname ASC
                    LIMIT ?";
            $stmt = $conn->prepare($sql);
            if (!$stmt) throw new Exception("MySQLi prepare failed: " . $conn->error);
            $stmt->bind_param('i', $limit);
        }
        $stmt->execute();
        $res = $stmt->get_result();
        while ($r = $res->fetch_assoc()) $rows[] = $r;
        $stmt->close();
        return $rows;
    }

    throw new Exception('Unknown DB connection type. $conn must be PDO or MySQLi.');
}
