<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="/assets/css/login.css">
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap');
  </style>
 
  <title>Login</title>
</head>

<body>
  <div class="container">
    <div class="title">
      <h1>Login</h1>
    </div>
    <form method="post" action="index.php?route=login">
      <div class="input-box">
        <input type="text" class="input-field" placeholder="username" name="username" id="username" required>
      </div>
      <div class="input-box">
        <input type="password" class="input-field" placeholder="password" name="password" id="password" required>
      </div>
      <div class="forget">
        <section>
          <input type="checkbox" class="rememberme" id="rememberme" name="rememberme">
          <label for="rememberme">remember me</label>
        </section>
        <section>
          <a href="index.php?route=sendemail" class="forgot-password">Forgot Password</a>
        </section>
      </div>
	  
	  <div class="google-login">
		<a href="index.php?route=google_login">
		
			<img src="/assets/images/web_light_rd_na@2x.png"  alt="Goole登入"> 
		</a>
	  
	  </div>
      <div class="sign-in">
        <button type="submit" class="login-btn" id="login-btn"></button>
        <label for="login-btn">Sign in</label>
      </div>
      <div class="sign-up">
        <p>Don't have an account? <a href="index.php?route=register">Sign up</a></p>
      </div>
    </form>
  </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
      <!-- 再 handler.js，一定要放這個，並加上版本強制更新 -->
      <script src="/assets/js/handler.js?v=<?= time() ?>"></script>
  
  <!--若你之後部署上線，正式環境建議用這樣的方式避免 time：
   <script src="/assets/js/handler.js?v=1.0.3"></script>
  這樣版本好控管，不會每次都重抓、影響效能。 -->

   <?php  include __DIR__. ('/../layouts/sweetalert.php')  ?>
</body>

</html>

