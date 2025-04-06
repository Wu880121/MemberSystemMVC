<!DOCTYPE html>
<html lang="zh-Hant-TW">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap');
  </style>
  
 	<link rel="stylesheet" href="/assets/css/register.css">
  <title>Form</title>
</head>

<body>
  <div class="container">
    <h1>Register Form</h1>
    <form method="post" action="index.php?route=register">

      <div class="flex-area">
        <div class="input-box">
          <label>Full Name</label>
          <input type="text" placeholder="Enter ull name" name="name" required />
        </div>

        <div class="input-box">
          <label>Username</label>
          <input type="text" placeholder="Enter username" name="username" required />
        </div>
      </div>

      <div class="flex-area">
        <div class="input-box">
          <label>Password</label>
          <input type="password" placeholder="Enter ull password" name="password" required />
        </div>

        <div class="input-box">
          <label>Confirm Password</label>
          <input type="password" placeholder="Enter username" name="confirm_password" required />
        </div>
      </div>

      <div class="input-box">
        <label>Email</label>
        <input type="email" placeholder="Enter email address" name="email" required />
      </div>

      <div class="column">
        <div class="input-box">
          <label>Phone Number</label>
          <input type="tel" placeholder="Enter phone number" name="tel" />
        </div>

        <div class="input-box">
          <label>Birthday Date</label>
          <input type="date" placeholder="Enter your birthday" name="birthdate" />
        </div>
      </div>

      <div class="gender-box">
        <h3>Gender</h3>
        <div class="gender-option">
          <div class="gender">
            <input type="radio" name="sex" id="sex-F" value="F" checked />
            <label for="sex-F">Female</label>
          </div>
          <div class="gender">
            <input type="radio" name="sex" id="sex-M" value="M" />
            <label for="sex-M">Male</label>
          </div>
          <div class="gender">
            <input type="radio" name="sex" id="sex-ALL" value="ALL" />
            <label for="sex-ALL">ALL</label>
          </div>
        </div>
      </div>

      <div class="Address-box">
        <label>Address</label>
        <div class="select-box">
          <select name="city" id="city" placeholder="city">
            <option hidden>City</option>
            <option value="New City Taipei">New City Taipei</option>
            <option value="Taipei">Taipei</option>
          </select>
          <div class="input-box">
            <label>Street</label>
            <input type="text" placeholder="Enter email address" name="street" required />
          </div>
        </div>
      </div>

      <button type="submit">submit</button>
    </form>
  </div>
  
  <?php  include __DIR__. ('/../layouts/sweetalert.php')  ?>
</body>
</html>



