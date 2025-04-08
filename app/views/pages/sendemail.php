<!DOCTYPE html>
<html lang="zh-Hant-TW">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="/assets/css/sendemail.css">
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap');
  </style>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.17.2/dist/sweetalert2.all.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.17.2/dist/sweetalert2.min.css">
  <title>forgetemail</title>
</head>

<body>
  <div class="container">
    <h1>忘記密碼</h1>
    <form method="post" action="index.php?route=sendemail">
      <div class="form-container">
        <label for="email">電子郵件：</label>
        <input
          type="email"
          id="email"
          name="email"
          placeholder="123456@gmail.com"
          required />
        <button type="submit">送出重設密碼郵件</button>
      </div>
    </form>
  </div>
  
  <?php  include __DIR__. ('/../layouts/sweetalert.php')  ?>
</body>

</html>

