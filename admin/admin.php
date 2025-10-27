<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fff5f0;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .report-title {
            font-size: 20px;
            margin-bottom: 20px;
        }
        .user-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #ddd;
        }
        .user-info {
            display: flex;
            align-items: center;
        }
        .user-avatar img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
        }
        .user-label {
            font-size: 16px;
            color: #333;
            margin-left: 10px;
        }
        .menu-name {
            background-color: #f0f2f5;
            padding: 8px 20px;
            border-radius: 5px;
            flex-grow: 1;
            margin: 0 10px;
            text-align: center;
            color: #666;
        }
        .status-icons {
            display: flex;
            gap: 10px;
        }
        .status-icons .icon {
            font-size: 24px;
            cursor: pointer;
        }
        .icon-approve {
            color: green;
        }
        .icon-reject {
            color: red;
        }
    </style>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body>

<div class="container">
    <div class="report-title">report</div>
    
    <!-- User Row 1 -->
    <div class="user-row">
        <div class="user-info">
            <div class="user-avatar">
                <img src="https://via.placeholder.com/40" alt="User Avatar">
            </div>
            <span class="user-label">user</span>
        </div>
        <div class="menu-name">ชื่อ เมนู</div>
        <div class="status-icons">
            <i class="fas fa-times-circle icon icon-reject"></i>
            <i class="fas fa-check-circle icon icon-approve"></i>
        </div>
    </div>

    <!-- User Row 2 -->
    <div class="user-row">
        <div class="user-info">
            <div class="user-avatar">
                <img src="https://via.placeholder.com/40" alt="User Avatar">
            </div>
            <span class="user-label">user</span>
        </div>
        <div class="menu-name">ชื่อ เมนู</div>
        <div class="status-icons">
            <i class="fas fa-times-circle icon icon-reject"></i>
            <i class="fas fa-check-circle icon icon-approve"></i>
        </div>
    </div>

    <!-- User Row 3 -->
    <div class="user-row">
        <div class="user-info">
            <div class="user-avatar">
                <img src="https://via.placeholder.com/40" alt="User Avatar">
            </div>
            <span class="user-label">user</span>
        </div>
        <div class="menu-name">ชื่อ เมนู</div>
        <div class="status-icons">
            <i class="fas fa-times-circle icon icon-reject"></i>
            <i class="fas fa-check-circle icon icon-approve"></i>
        </div>
    </div>

    <!-- User Row 4 -->
    <div class="user-row">
        <div class="user-info">
            <div class="user-avatar">
                <img src="https://via.placeholder.com/40" alt="User Avatar">
            </div>
            <span class="user-label">user</span>
        </div>
        <div class="menu-name">ชื่อ เมนู</div>
        <div class="status-icons">
            <i class="fas fa-times-circle icon icon-reject"></i>
            <i class="fas fa-check-circle icon icon-approve"></i>
        </div>
    </div>

</div>

</body>
</html>
