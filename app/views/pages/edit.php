<!-- views/pages/editor.php -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>編輯使用者</title>
  <link rel="stylesheet" href="/assets/css/edit.css"> <!-- 自訂 CSS -->
</head>
<body>
  <div class="form-container">
    <h2>Edit User</h2>


    <form method="POST" action="index.php?route=edit">
      <input type="hidden" name="id" value="<?= htmlspecialchars($results['id'] ?? '') ?>">

      <label>Username</label>
      <input type="text" name="username" value="<?= htmlspecialchars($results['username'] ?? '') ?>" required>

      <label>Email</label>
      <input type="email" name="email" value="<?= htmlspecialchars($results['email'] ?? '') ?>" required>

      <label>Telephone</label>
      <input type="text" name="tel" value="<?= htmlspecialchars($results['tel'] ?? '') ?>">

      <label>Birthdate</label>
      <input type="date" name="birthdate" value="<?= htmlspecialchars($results['birthdate'] ?? '') ?>">

      <label>Sex</label>
      <select name="sex">
        <option value="M" <?= ($results['sex'] ?? '') === 'M' ? 'selected' : '' ?>>Male</option>
        <option value="F" <?= ($results['sex'] ?? '') === 'F' ? 'selected' : '' ?>>Female</option>
      </select>

      <label>City</label>
      <input type="text" name="city" value="<?= htmlspecialchars($results['city'] ?? '') ?>">

      <label>Street</label>
      <input type="text" name="street" value="<?= htmlspecialchars($results['street'] ?? '') ?>">

      <label>Role</label>
      <select name="role">
        <option value="user" <?= ($results['role'] ?? '') === 'user' ? 'selected' : '' ?>>User</option>
        <option value="admin" <?= ($results['role'] ?? '') === 'admin' ? 'selected' : '' ?>>Admin</option>
      </select>

      <label>New Password (optional)</label>
      <input type="password" name="password" placeholder="Leave blank to keep current password">

      <button type="submit">Save Changes</button>
    </form>
  </div>
  
  <?php  include __DIR__. ('/../layouts/sweetalert.php')  ?>
</body>
</html>
