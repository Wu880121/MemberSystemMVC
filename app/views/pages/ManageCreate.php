<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新增管理者帳號</title>
</head>
<body>

   <style>
    * {
        box-sizing: border-box;
    }

    body {
        font-family: 'Microsoft JhengHei', sans-serif;
        background-color: #f2f2f2;
        margin: 0;
        padding: 0;
    }

    .form-container {
        max-width: 500px;
        background-color: white;
        margin: 50px auto;
        padding: 30px;
        border-radius: 16px;
        box-shadow: 0 4px 16px rgba(0,0,0,0.1);
    }

    h2 {
        text-align: center;
        margin-bottom: 20px;
    }

    .form-group {
        margin-bottom: 15px;
    }

    label {
        display: block;
        font-weight: bold;
        margin-bottom: 6px;
    }

    input[type="text"],
    input[type="password"],
    input[type="email"],
    input[type="date"],
    select {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 14px;
    }

    button {
        width: 100%;
        padding: 12px;
        background-color: #4CAF50;
        color: white;
        font-size: 16px;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        transition: background-color 0.2s ease-in-out;
    }

    button:hover {
        background-color: #45a049;
    }

    .alert {
        background-color: #ffe6e6;
        border-left: 5px solid red;
        padding: 10px;
        color: #b30000;
        margin-bottom: 20px;
        border-radius: 6px;
    }

    @media (max-width: 600px) {
        .form-container {
            padding: 20px;
            margin: 20px;
        }
    }
</style>

<div class="form-container">
    <h2>新增管理者帳號</h2>

    <?php if (!empty($_SESSION['alert'])): ?>
        <div class="alert">
            <?= htmlspecialchars($_SESSION['alert']['message']) ?>
        </div>
        <?php unset($_SESSION['alert']); ?>
    <?php endif; ?>

    <form method="POST" action="index.php?route=create">
        <div class="form-group">
            <label>姓名</label>
            <input type="text" name="name" required>
        </div>

        <div class="form-group">
            <label>帳號</label>
            <input type="text" name="username" required>
        </div>

        <div class="form-group">
            <label>密碼</label>
            <input type="password" name="password" required>
        </div>

        <div class="form-group">
            <label>確認密碼</label>
            <input type="password" name="confirm_password" required>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email">
        </div>

        <div class="form-group">
            <label>電話</label>
            <input type="text" name="tel">
        </div>

        <div class="form-group">
            <label>生日</label>
            <input type="date" name="birthdate">
        </div>

        <div class="form-group">
            <label>性別</label>
            <select name="sex">
                <option value="">請選擇</option>
                <option value="M">男</option>
                <option value="F">女</option>
            </select>
        </div>

        <div class="form-group">
            <label>城市</label>
            <input type="text" name="city">
        </div>

        <div class="form-group">
            <label>街道</label>
            <input type="text" name="street">
        </div>

        <button type="submit">新增帳號</button>
    </form>
</div>

   <?php  include __DIR__. ('/../layouts/sweetalert.php')  ?>

</body>
</html>
