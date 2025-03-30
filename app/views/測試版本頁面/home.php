<?php

$user = $_SESSION['user'] ?? null;
$username = $user['username'] ?? '訪客';
?>
<h2>歡迎回來，<?= htmlspecialchars($username) ?>！</h2>

<p><a href="index.php?route=logout">登出</a></p>