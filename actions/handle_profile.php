<?php
// actions/handle_profile.php

require '../includes/auth_check.php'; // WAJIB!
require '../config/database.php';

$user_id = $_SESSION['user_id'];
$action = $_POST['action'] ?? null;

try {
    if ($action == 'update_profile') {
        // Logika untuk update profil (Nama Lengkap)
        $full_name = trim($_POST['full_name']);
        
        $stmt = $pdo->prepare("UPDATE users SET full_name = ? WHERE id = ?");
        $stmt->execute([$full_name, $user_id]);
        
        $_SESSION['success_msg'] = "Profil berhasil diperbarui.";

    } elseif ($action == 'change_password') {
        // Logika untuk ubah password
        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        // 1. Cek password baru vs konfirmasi
        if ($new_password !== $confirm_password) {
            throw new Exception("Password baru dan konfirmasi tidak cocok.");
        }

        // 2. Cek password saat ini
        $stmt = $pdo->prepare("SELECT password FROM users WHERE id = ?");
        $stmt->execute([$user_id]);
        $user = $stmt->fetch();

        if (!$user || !password_verify($current_password, $user['password'])) {
            throw new Exception("Password saat ini salah.");
        }

        // 3. Semua valid, hash dan update password baru
        $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
        $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->execute([$hashed_password, $user_id]);

        $_SESSION['success_msg'] = "Password berhasil diubah.";
    }

} catch (Exception $e) {
    // Tangkap semua error
    $_SESSION['error_msg'] = $e->getMessage();
}

// Redirect kembali ke halaman profil
header("Location: ../profile.php");
exit();
?>