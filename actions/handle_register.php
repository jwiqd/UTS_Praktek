<?php
// actions/handle_register.php

session_start();
require '../config/database.php';
require '../config/mailer.php'; // PHPMailer (lihat di bawah)

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // 1. Validasi (email valid, password cukup kuat, dll.)
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Email tidak valid.");
    }
    
    // 2. Cek email unik
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        // Gagal: Email sudah terdaftar
        $_SESSION['error_msg'] = "Email sudah terdaftar. Silakan gunakan email lain.";
        header("Location: ../register.php");
        exit();
    }

    // 3. Hash password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // 4. Buat token aktivasi
    $activation_token = bin2hex(random_bytes(32));

    // 5. Simpan ke database
    try {
        $stmt = $pdo->prepare(
            "INSERT INTO users (email, password, role, status, activation_token) 
             VALUES (?, ?, 'Admin Gudang', 'PENDING', ?)"
        );
        $stmt->execute([$email, $hashed_password, $activation_token]);
        
        // 6. Kirim email aktivasi
        //$activation_link = "http://localhost/gudang-manajemen/activate.php?token=" . $activation_token;
        $activation_link = "http://localhost/webpro5d/UTS_Praktek/activate.php?token=" . $activation_token;
        
        $mail->addAddress($email);
        $mail->Subject = 'Aktivasi Akun Anda - Manajemen Gudang';
        $mail->Body    = "Selamat datang! Klik tautan berikut untuk mengaktifkan akun Anda: <br><br>
                          <a href='$activation_link'>$activation_link</a>";

        $mail->send();
        
        $_SESSION['success_msg'] = "Registrasi berhasil. Silakan cek email Anda untuk aktivasi.";
        header("Location: ../login.php");
        exit();

    } catch (Exception $e) {
        // Gagal kirim email atau DB error
        $_SESSION['error_msg'] = "Registrasi gagal: " . $e->getMessage();
        header("Location: ../register.php");
        exit();
    }
}
?>