<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$flash = $_SESSION['contact_flash'] ?? null;
if (isset($_SESSION['contact_flash'])) unset($_SESSION['contact_flash']);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Admin Login</title>
<link rel="stylesheet" href="../assets/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5" style="max-width:420px;">
    <h4 class="mb-3">Login Admin</h4>
    <?php if (!empty($flash)): ?>
        <div class="alert alert-<?php echo ($flash['status']==='success'?'success':'danger'); ?>"><?php echo htmlspecialchars($flash['msg']); ?></div>
    <?php endif; ?>
    <form action="login_handler.php" method="post">
        <div class="mb-3">
            <label>Username</label>
            <input name="username" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <button class="btn btn-primary">Login</button>
            <a class="btn btn-secondary" href="../index.php">Kembali</a>
        </div>
    </form>
</div>
</body>
</html>
