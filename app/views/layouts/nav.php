<div class="nav">
    <h1>Eating for you</h1>
    <ul>
      <li>
        <a href="index.php?route=login"><i class="fa-regular fa-user"></i></a>
      </li>
      <li>
        <a href="index.php?route=home"><i class="fa-regular fa-clipboard"></i></a>
      </li>
      <li>
        <a href="index.php?route=map"><i class="fa-regular fa-envelope"></i></a>
      </li>
      <!-- 使用者已登入，顯示登出按鈕 -->
   
      <?php if (isset($_SESSION['user'])): ?>
        <button onclick="window.location.href='index.php?route=logout'">登出</button>
      <?php else: ?>
        <!-- 使用者未登入，顯示登入按鈕 -->
        <button onclick="'index.php?route=login'">登入</button>
      <?php endif; ?>
    </ul>
  </div>
