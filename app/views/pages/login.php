<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="/assets/css/login.css">

  <script src="/assets/js/login-handler.js"></script>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap');
  </style>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.17.2/dist/sweetalert2.all.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.17.2/dist/sweetalert2.min.css">
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
          <a href="sendemail.php" class="forgot-password">Forgot Password</a>
        </section>
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
</body>

</html>

