<?php
// config/mailer.php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//require 'vendor/autoload.php'; // Path ke autoload Composer
require __DIR__ . '/../vendor/autoload.php';
$mail = new PHPMailer(true);

try {
    // Pengaturan Server SMTP
    // $mail->SMTPDebug = SMTP::DEBUG_SERVER;  // Aktifkan untuk debugging
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com'; // Ganti dengan host SMTP Anda (mis: 'smtp.gmail.com')
    $mail->SMTPAuth   = true;
    $mail->Username   = 'irvan.reki2005@gmail.com'; // Ganti dengan email SMTP Anda
    $mail->Password   = 'ztya puhs tnwm pnpz'; // Ganti dengan password SMTP Anda
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // atau SMTPS
    $mail->Port       = 465; // atau 465 untuk SMTPS

    // Pengirim
    $mail->setFrom('no-reply@gudang.com', 'Admin Gudang');
    
    // Konten
    $mail->isHTML(true);

} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>