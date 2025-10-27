<?php
session_start();
include '../db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $username = $_POST['username'];
    $email = $_POST['email'];

    // อัปเดตข้อมูลในฐานข้อมูล
    $sql = "UPDATE users SET username = :username, email = :email WHERE user_id = :user_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['username' => $username, 'email' => $email, 'user_id' => $user_id]);

    // ส่งกลับไปยังโปรไฟล์หลังจากอัปเดตเสร็จ
    header("Location: profile.php");
    exit();
}
?>