<?php
// activate.php

session_start();
require 'config/database.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Cari token di database
    $stmt = $pdo->prepare("SELECT id FROM users WHERE activation_token = ? AND status = 'PENDING'");
    $stmt->execute([$token]);
    $user = $stmt->fetch();

    if ($user) {
        // Token valid -> Aktifkan pengguna
        $stmt = $pdo->prepare("UPDATE users SET status = 'AKTIF', activation_token = NULL WHERE id = ?");
        $stmt->execute([$user['id']]);

        $_SESSION['success_msg'] = "Akun Anda telah berhasil diaktifkan! Silakan login.";
        header("Location: login.php");
        exit();
    } else {
        // Token tidak valid atau sudah digunakan
        $_SESSION['error_msg'] = "Tautan aktivasi tidak valid atau telah kedaluwarsa.";
        header("Location: login.php");
        exit();
    }
} else {
    // Tidak ada token
    $_SESSION['error_msg'] = "Tautan aktivasi tidak ditemukan.";
    header("Location: login.php");
    exit();
}
?>