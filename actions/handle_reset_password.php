<?php

session_start();
require '../config/database.php';

date_default_timezone_set('Asia/Jakarta');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $token = $_POST['token'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password !== $confirm_password) {
        $_SESSION['error_msg'] = "Password dan konfirmasi password tidak cocok.";
        header("Location: ../reset_password.php?token=" . urlencode($token));
        exit();
    }

    // Validasi ulang token dengan waktu PHP yang sudah dipaksa
    $current_time_php = date('Y-m-d H:i:s'); 
    
    $stmt = $pdo->prepare("SELECT id FROM users WHERE reset_token = ? AND reset_token_expiry > ?");
    $stmt->execute([$token, $current_time_php]);
    $user = $stmt->fetch();

    if (!$user) {
        $_SESSION['error_msg'] = "Tautan reset tidak valid atau telah kedaluwarsa (handle).";
        header("Location: ../login.php");
        exit();
    }

    // Token valid -> Update password
    $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
    
    $stmt = $pdo->prepare("UPDATE users SET password = ?, reset_token = NULL, reset_token_expiry = NULL WHERE id = ?");
    $stmt->execute([$hashed_password, $user['id']]);

    $_SESSION['success_msg'] = "Password Anda telah berhasil diubah. Silakan login.";
    header("Location: ../login.php");
    exit();
}
?>