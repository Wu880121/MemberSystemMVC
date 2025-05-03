<!DOCTYPE html>
<html lang="zh-Hant">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>註冊成功</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            background-color: #f0f4f8;
            font-family: 'Microsoft JhengHei', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .card {
            background: white;
            padding: 40px 30px;
            border-radius: 20px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 400px;
            width: 90%;
        }

        .card h1 {
            color: #4CAF50;
            font-size: 28px;
            margin-bottom: 20px;
        }

        .card p {
            font-size: 16px;
            color: #555;
            margin-bottom: 30px;
        }

        .card a {
            display: inline-block;
            padding: 12px 25px;
            background-color: #4CAF50;
            color: white;
            border-radius: 10px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .card a:hover {
            background-color: #43a047;
        }
    </style>
</head>

<body>
    <div class="card">
        <h1>🎉 註冊成功！</h1>
        <p>已寄送驗證信到您的信箱<br>請前往信箱完成驗證，才能登入使用。</p>
        <a href="index.php?route=login">前往登入</a>

        <p class="mt-3" style="margin-top:20px; font-size:14px;">
            還沒收到驗證信？<br>
			<?php $urlEmail = $_GET['email'];?>
            <a href="index.php?route=resendVerifyToken&email={$urlEmail}" style="background:none; color:#4CAF50; text-decoration:underline; padding:0;">重新寄送</a>
        </p>
    </div>
</body>

</html>
