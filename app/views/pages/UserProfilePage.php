<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>會員資料編輯</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: "Microsoft JhengHei", sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 3rem auto;
            padding: 2rem;
            background-color: #ffffff;
            border-radius: 16px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        }

        h2 {
            text-align: center;
            margin-bottom: 1.5rem;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-top: 1rem;
            margin-bottom: 0.25rem;
            font-weight: bold;
        }

        input, select {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 1rem;
        }

        button {
            margin-top: 2rem;
            padding: 12px;
            background-color: #4caf50;
            color: white;
            font-size: 1rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #45a049;
        }
		
		    .button-group {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        justify-content: center;
    }

    .button-group button {
        flex: 1;
        min-width: 120px;
    }

        @media (max-width: 768px) {
            .container {
                margin: 1rem;
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h2>會員資料編輯</h2>
	
	<form method="POST" action="index.php?route=UserProfile" enctype="multipart/form-data">
	<label>大頭照:</label>
   <img src="<?= htmlspecialchars(!empty($user['avatar_path']) ? '/uploads/avatars/default.png':$user['avatar_path']) ?>" alt="大頭照" width="100">
	<input type="file" name="avatar" accept="image/*" >
	<button type="submit">上傳</button>

        <label for="name">姓名</label>
        <input type="text" id="name" name="name" value="<?= htmlspecialchars($user['name'] ?? '') ?>" readonly>

        <label for="email">電子郵件</label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>" readonly>

        <label for="tel">電話</label>
        <input type="tel" id="tel" name="tel" value="<?= htmlspecialchars($user['tel'] ?? '') ?>">

        <label for="birthdate">生日</label>
        <input type="date" id="birthdate" name="birthdate" value="<?= htmlspecialchars($user['birthdate'] ?? '') ?>">

        <label for="sex">性別</label>
        <select id="sex" name="sex">
            <option value="男" <?= ($user['sex'] ?? '') === '男' ? 'selected' : '' ?>>男</option>
            <option value="女" <?= ($user['sex'] ?? '') === '女' ? 'selected' : '' ?>>女</option>
            <option value="其他" <?= ($user['sex'] ?? '') === '其他' ? 'selected' : '' ?>>其他</option>
        </select>

        <label for="city">城市</label>
        <input type="text" id="city" name="city" value="<?= htmlspecialchars($user['city'] ?? '') ?>">

        <label for="street">街道</label>
        <input type="text" id="street" name="street" value="<?= htmlspecialchars($user['street'] ?? '') ?>">
			
         <div class="button-group">
            <button type="submit">更新資料</button>
            <button type="button" onclick="window.location.href='index.php?route=map';">確認無誤</button>
        </div>
		
    <?php if (isset($_SEESION['warrning'])):    ?>
	<p style='color:red;' >
	<?= htmlspecialchars($_SEESION['warrning']['message']); ?>
	</p>
    <?php unset($_SESSION['warrning']); // 顯示完就刪掉 ?>
    <?php endif; ?>
    </form>
</div>
   <?php  include __DIR__. ('/../layouts/sweetalert.php')  ?>
</body>
</html>
