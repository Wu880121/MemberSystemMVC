<div class="nav">
    <h1>Eating for you</h1>
    <ul>
      <li>
        <a href="index.php?route=UserProfile"><i class="fa-regular fa-user"></i></a>
      </li>
      <li>
        <a href="index.php?route=home"><i class="fa-regular fa-clipboard"></i></a>
      </li>
      <li>
        <a href="index.php?route=map"><i class="fa-regular fa-envelope"></i></a>
      </li>
      <!-- 使用者已登入，顯示登出按鈕 -->
   
      <?php if (isset($_COOKIE['token'])): ?>
	   <li>
        <a href="index.php?route=logout"><i class="fa-solid fa-right-from-bracket"></i></a>
		</li>
      <?php else: ?>
        <!-- 使用者未登入，顯示登入按鈕 -->
		<li>
        <a href="index.php?route=login"><i class="fa-solid fa-right-to-bracket"></i></a>
		</li>
      <?php endif; ?>
    </ul>
  </div>
  
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
          <li><a href="index.php?route=home">Home</a></li>
          <li><a href="index.php?route=UserProfile">Profile</a></li>
          <li><a href="index.php?route=map">AboutUs</a></li>
          <?php if (isset($_COOKIE['token'])): ?>
            <li><a href="logout.php">登出</a></li>
          <?php else: ?>
            <li><a href="login.php">登入</a></li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </div>
  <!-- -------------手機版結束--------------------------- -->
