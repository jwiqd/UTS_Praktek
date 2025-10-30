<?php
// logout.php
session_start();

// Hapus semua variabel sesi
$_SESSION = array();

// Hancurkan sesi
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

session_destroy();

// Redirect ke halaman login dengan pesan sukses
session_start(); // Mulai sesi baru untuk pesan
$_SESSION['success_msg'] = "Anda telah berhasil logout.";
header("Location: login.php");
exit();
?>