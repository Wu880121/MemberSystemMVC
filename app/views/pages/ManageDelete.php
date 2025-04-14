<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <title>刪除使用者</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            padding: 50px;
        }

        .container {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        h3 {
            margin-bottom: 30px;
        }

        .btn-group {
            display: flex;
            justify-content: space-between;
        }
    </style>
</head>
<body>

<div class="container">
    <h3 class="text-center">⚠️ 確認刪除使用者</h3>

    <form method="POST" action="index.php?route=delete">
        <input type="hidden" name="id" value="<?= htmlspecialchars($_GET['id']) ?>">

        <p class="text-danger text-center">
            確定要刪除 <strong>Username:  ⚠️<?= htmlspecialchars($results['username']) ?>⚠️</strong> 的使用者嗎？此操作無法復原。
        </p>

        <div class="btn-group mt-4">
            <a href="index.php?route=dashboard" class="btn btn-secondary">取消</a>
            <button type="submit" class="btn btn-danger">確認刪除</button>
        </div>
    </form>
</div>
       <?php  include __DIR__. ('/../layouts/sweetalert.php')  ?>
</body>
</html>
