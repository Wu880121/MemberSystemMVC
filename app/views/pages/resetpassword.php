<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <link rel="stylesheet" href="/assets/css/resetpassword.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap');
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.17.2/dist/sweetalert2.all.min.js"></script>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.css' integrity='sha512-GmZYQ9SKTnOea030Tbiat0Y+jhnYLIpsGAe6QTnToi8hI2nNbVMETHeK4wm4MuYMQdrc38x+sX77+kVD01eNsQ==' crossorigin='anonymous' />
    <title>Document</title>
</head>

<body>
    <div class="container">
        <div class="heading">Change Password</div>
        <form method="post" action=" index.php?route=resetpassword&token=<?php echo htmlspecialchars($_GET["token"] ?? ''); ?>">
            <!-- ?? '' (Null 合併運算子)
            如果 token 存在，則回傳 $_GET['token']。
            如果 token 不存在 (例如 resetpassword.php 沒有 ?token=123456)，則回傳 '' (空字串)，避免 Undefined index 錯誤。-->
            <div class="entryarea">
                <input type="password" name="password" placeholder=" " required>
                <span class="labelline">New Password</span>
                <i class="fa-solid fa-eye-slash"></i>
            </div>
            <div class="entryarea">
                <input type="password" name="confirm_password" placeholder=" " required>
                <span class="labelline">Confirm New Password</span>
                <i class="fa-solid fa-eye-slash"></i>
            </div>

            <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET["token"] ?? ''); ?>">
            <button type="submit" id="btn">Submit</button>

        </form>
    </div>
	
	<?php  include __DIR__. ('/../layouts/sweetalert.php')  ?>
</body>

</html>
