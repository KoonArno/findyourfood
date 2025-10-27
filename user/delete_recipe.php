<?php
session_start();
include '../db.php';

if (isset($_GET['id'])) {
    $food_id = $_GET['id'];
    $sql = "DELETE FROM food WHERE FoodId = :food_id";
    $stmt = $conn->prepare($sql);
    if ($stmt->execute(['food_id' => $food_id])) {
        header("Location: your_recipe.php?status=success");
    } else {
        header("Location: your_recipe.php?status=error");
    }
    exit();
}
?>
