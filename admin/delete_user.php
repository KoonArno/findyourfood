<?php
session_start();
include '../db.php';
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];
    // ลบผู้ใช้จากฐานข้อมูล
    $sql = "DELETE FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt->execute([$user_id])) {
        header("Location: manage_user.php?status=success");
        exit();
    } else {
        header("Location: manage_user.php?status=error");
        exit();
    }
}