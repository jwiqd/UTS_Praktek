<?php


session_start();
require '../config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    if ($user && password_verify($password, $user['password'])) {
        
        if ($user['status'] != 'AKTIF') {
            $_SESSION['error_msg'] = "Akun Anda belum aktif. Silakan cek email aktivasi.";
            header("Location: ../login.php");
            exit();
        }

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_role'] = $user['role'];
        
        
        header("Location: ../dashboard.php");
        exit();

    } else {
        $_SESSION['error_msg'] = "Email atau password salah.";
        header("Location: ../login.php");
        exit();
    }
}
?>