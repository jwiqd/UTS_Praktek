<?php


// Mulai sesi jika belum dimulai
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Cek apakah user_id ada di sesi
if (!isset($_SESSION['user_id'])) {
    // Jika tidak, redirect ke halaman login
    $_SESSION['error_msg'] = "Anda harus login untuk mengakses halaman ini.";
    header("Location: login.php");
    exit();
}


?>