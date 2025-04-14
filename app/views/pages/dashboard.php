<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <title>管理後台</title>
    <style>
        body {
            font-family: "Noto Sans TC", sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
        }
        .navbar {
            background-color: #34495e;
            color: white;
            padding: 15px 20px;
        }
        .container {
            padding: 30px;
        }
        .card {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="navbar">
        管理後台 - Dashboard
    </div>

    <div class="container">
        <h2>歡迎回來，<?= htmlspecialchars($nameOrEmail) ?> 👋</h2>

        <div class="card">
            <h3>系統狀態</h3>
            <p>這是一個簡單的管理後台頁面，你可以在這裡擴充更多功能。</p>
        </div>

        <div class="card">
            <h3>快速連結</h3>
            <ul>
                <li><a href="/index.php?route=manage">使用者列表</a></li>
                <li><a href="/index.php?route=logout">登出</a></li>
            </ul>
        </div>
    </div>
	
	   <?php  include __DIR__. ('/../layouts/sweetalert.php')  ?>
</body>
</html>