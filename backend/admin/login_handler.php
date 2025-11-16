<?php
require_once __DIR__ . '/../config/admin.php';
if (session_status() === PHP_SESSION_NONE) session_start();

$admin = require __DIR__ . '/../config/admin.php';

$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

function redirect_with_msg($status, $msg) {
    $_SESSION['contact_flash'] = ['status' => $status, 'msg' => $msg];
    header('Location: login.php');
    exit;
}

if ($username === $admin['username'] && $password === $admin['password']) {
    // login success
    $_SESSION['admin_logged_in'] = true;
    $_SESSION['admin_user'] = $username;
    header('Location: pendaftaran.php');
    exit;
} else {
    redirect_with_msg('error', 'Username atau password salah.');
}
