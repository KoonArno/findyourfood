<?php
session_start();
include('db.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Find Your Food</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="index-styles.css">
</head>

<body>
    <?php include './partials/header.php'; ?>
        <div class="hero">
            <div class="hero-content">
                <h1 class="text-shadow">LIFE FOR EATING</h1>
            </div>
            <div class="hero-image">
                <img src="Png1.png" alt="Delicious Burger">
            </div>
        </div>
</body>



</html>