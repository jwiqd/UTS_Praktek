<?php

session_start();
require '../config/database.php';
require '../config/mailer.php'; 
date_default_timezone_set('Asia/Jakarta');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);

    // 1. Cek apakah email ada
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {
        // 2. Buat token reset
        $reset_token = bin2hex(random_bytes(32));
        // Token berlaku selama 1 jam
        $expiry_time = date('Y-m-d H:i:s', time() + 3600); 

        // 3. Simpan token ke database
        try {
            $stmt = $pdo->prepare("UPDATE users SET reset_token = ?, reset_token_expiry = ? WHERE id = ?");
            $stmt->execute([$reset_token, $expiry_time, $user['id']]);

            // 4. Kirim email reset
            //$reset_link = "http://localhost/gudang-manajemen/reset_password.php?token=" . $reset_token;
            $reset_link = "http://localhost/webpro5d/UTS_Praktek/reset_password.php?token=" . $reset_token; 
            
            $mail->addAddress($email);
            $mail->Subject = 'Reset Password - Manajemen Gudang';
            $mail->Body    = "Seseorang (semoga Anda) meminta untuk me-reset password akun Anda. 
                              Klik tautan berikut untuk membuat password baru: <br><br>
                              <a href='$reset_link'>$reset_link</a><br><br>
                              Tautan ini akan kedaluwarsa dalam 1 jam.";

            $mail->send();

        } catch (Exception $e) {
            // Gagal kirim email atau DB error, tapi jangan beritahu user
            // Ini untuk keamanan (mencegah email enumeration)
        }
    }

    // Tampilkan pesan sukses generik
    // Ini PENTING untuk keamanan. Jangan beritahu jika email "tidak ditemukan".
    $_SESSION['success_msg'] = "Jika email Anda terdaftar, tautan reset password telah dikirim.";
    header("Location: ../login.php");
    exit();
}
?>