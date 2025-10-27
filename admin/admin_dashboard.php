<?php
session_start();
include('../db.php');

// ตรวจสอบการเข้าสู่ระบบ
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include 'admin_header.php';
?>
<div class="container mt-4">
    <h1>Admin Dashboard</h1>
    <p>ยินดีต้อนรับเข้าสู่หน้า Dashboard ของผู้ดูแลระบบ</p>
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Manage Recipe</h5>
                    <p class="card-text">จัดการสูตรอาหารในระบบ</p>
                    <a href="manage_recipe.php" class="btn btn-primary">Go</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Manage Users</h5>
                    <p class="card-text">จัดการผู้ใช้งานในระบบ</p>
                    <a href="manage_user.php" class="btn btn-primary">Go</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Bootstrap JavaScript -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script >