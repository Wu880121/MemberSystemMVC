<!DOCTYPE html>
<html lang="zh-Hant">
<head>

<!-- Bootstrap 5 CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <meta charset="UTF-8">
    <title>使用者管理</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f6f8fa;
    }

    .container {
        max-width: 1200px; /* 原本是 960，這邊變寬一點 */
        margin: 30px auto;
        background-color: white;
        padding: 40px;
        box-shadow: 0 0 15px rgba(0,0,0,0.1);
        border-radius: 10px;
    }

    h2 {
        margin-top: 0;
    }

    a.button {
        display: inline-block;
        margin-bottom: 20px;
        padding: 10px 18px;
        background-color: #2c974b;
        color: white;
        border-radius: 5px;
        text-decoration: none;
    }

    a.button:hover {
        background-color: #26753c;
    }

    table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 10px; /* 表格 row 之間距離 */
    }

    th, td {
        padding: 14px;
        text-align: center;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #f0f0f0;
    }

    td a {
        color: #0366d6;
        text-decoration: none;
        margin: 0 5px;
    }

    td a:hover {
        text-decoration: underline;
    }

    .action-links {
        white-space: nowrap;
    }

    nav .pagination {
        margin-top: 40px;
    }
</style>

</head>
<body>

<header style="display: flex; justify-content: space-between; align-items: center; background-color: #24292e; color: white; padding: 15px 30px; font-size: 20px;">
    <div>使用者管理系統</div>
    <a href="index.php?route=dashboard" style="text-decoration: none; background-color: #28a745; color: white; padding: 8px 15px; border-radius: 5px; font-size: 16px;">
        回 Dashboard
    </a>
</header>

<div class="container">
    <h2>使用者列表</h2>
	
	<!-- 搜尋欄開始 -->
	<?php $search = $_GET['search'] ?? ''; ?>
<form action="index.php?route=manageSearch" method="GET" class="mb-4" style="display: flex; gap: 10px; align-items: center;">
    <input type="hidden" name="route" value="manageSearch">
    <input type="text" name="search" placeholder="🔍 輸入帳號或Email搜尋..." value="<?= htmlspecialchars($search) ?>" class="form-control" style="max-width: 300px; border-radius: 6px; padding: 8px 12px;">
    <button type="submit" class="btn btn-primary" style="padding: 8px 20px; border-radius: 6px;">搜尋</button>
	
	    <?php if (!empty($search)): ?>
        <a href="index.php?route=manage" class="btn btn-outline-secondary" style="padding: 8px 20px; border-radius: 6px;">清除搜尋</a>
    <?php endif; ?>
</form>
<!-- 搜尋欄結束 -->
	
    <a href="index.php?route=create" class="button">➕ 新增使用者</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>帳號</th>
                <th>郵件</th>
                <th>電話</th>
				<th>生日</th>
				<th>性別</th>
				<th>城市</th>
				<th>街區</th>
				<th>角色</th>
				<th>操作</th>
            </tr>
        </thead>
        <tbody>
		
			<?php $count = $offset + 1; ?>
            <?php foreach ($results as $result): ?>
            <tr>
                <td><?= $count++; ?></td>
                <td><?= htmlspecialchars($result['username']??' ')?></td>
                <td><?= htmlspecialchars($result['email']??' ') ?></td>
				<td><?= htmlspecialchars($result['tel']??' ') ?></td>
				<td><?= htmlspecialchars($result['birthdate']??' ') ?></td>
				<td><?= htmlspecialchars($result['sex']??' ')  ?></td>
				<td><?= htmlspecialchars($result['city']??' ')  ?></td>
				<td><?= htmlspecialchars($result['street']??' ')  ?></td>
				<td><?= htmlspecialchars($result['role']??' ') ?></td>
                <td class="action-links">
                    <a href="index.php?route=edit&id=<?= htmlspecialchars($result['id']??' ')  ?>">✏️ 編輯</a>
                    <a href="index.php?route=delete&id=<?= htmlspecialchars($result['id']??' ')  ?>" onclick="return confirm('確定要刪除?')">🗑️ 刪除</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- 表格顯示 users 的部分略... -->

<?php
$visibleRange = 3;
$start = max(1, $page - $visibleRange);
$end = min($totalPages, $page + $visibleRange);
?>

<nav aria-label="Page navigation" class="mt-4">
  <ul class="pagination justify-content-center">

    <?php if ($page > 1): ?>
      <li class="page-item">
        <a class="page-link" href="index.php?route=manage&page=<?= $page - 1 ?>">&laquo; 上一頁</a>
      </li>
    <?php endif; ?>

    <?php if ($start > 1): ?>
      <li class="page-item"><a class="page-link" href="index.php?route=manage&page=1">1</a></li>
      <li class="page-item disabled"><span class="page-link">...</span></li>
    <?php endif; ?>

    <?php for ($i = $start; $i <= $end; $i++): ?>
      <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
        <a class="page-link" href="index.php?route=manage&page=<?= $i ?>"><?= $i ?></a>
      </li>
    <?php endfor; ?>

    <?php if ($end < $totalPages): ?>
      <li class="page-item disabled"><span class="page-link">...</span></li>
      <li class="page-item"><a class="page-link" href="index.php?route=manage&page=<?= $totalPages ?>"><?= $totalPages ?></a></li>
    <?php endif; ?>

    <?php if ($page < $totalPages): ?>
      <li class="page-item">
        <a class="page-link" href="index.php?route=manage&page=<?= $page + 1 ?>">下一頁 &raquo;</a>
      </li>
    <?php endif; ?>

  </ul>
</nav>

   <?php  include __DIR__. ('/../layouts/sweetalert.php')  ?>

</body>
</html>
