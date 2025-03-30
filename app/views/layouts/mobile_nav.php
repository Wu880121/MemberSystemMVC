<!-- --------------手機板--------------------- -->
  <div class="nav-phone">
    <div class="burger">
      <h1>Eating for you</h1>
      <input type="checkbox" name="" id="checkbox" class="checkbox-toggles" />
      <label for="checkbox" class="checkbox-icon">
        <ul class="burger-menu">
          <li id="line1"></li>
          <li id="line2"></li>
          <li id="line3"></li>
        </ul>
        <div id="overlay"></div>
      </label>

      <div class="nav-menu">
        <ul>
          <li><a href="login.php">Home</a></li>
          <li><a href="aboutUs.php">About</a></li>
          <li><a href="map.php">Services</a></li>
          <li><a href="#">Contact</a></li>
          <?php if (isset($_SESSION['members'])): ?>
            <li><a href="logout.php">登出</a></li>
          <?php else: ?>
            <li><a href="login.php">登入</a></li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </div>
  <!-- -------------手機版結束--------------------------- -->