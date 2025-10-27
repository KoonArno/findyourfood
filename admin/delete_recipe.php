<?php
session_start();
include '../db.php';

if (isset($_GET['id'])) {
    $ebook_id = $_GET['id'];
    $sql = "DELETE FROM food WHERE FoodId = :food_id";
    $stmt = $conn->prepare($sql);
    if ($stmt->execute(['food_id' => $ebook_id])) {
        header("Location: manage_recipe.php?status=success");
    } else {
        header("Location: manage_recipe.php?status=error");
    }
    exit();
}
// หลังจากลบเสร็จ กลับไปที่หน้า manage_users.php
header("Location: manage_recipe.php");
?>
