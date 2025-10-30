<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


require __DIR__ . '/../vendor/autoload.php';
$mail = new PHPMailer(true);

try {
    // Pengaturan Server SMTP
    // $mail->SMTPDebug = SMTP::DEBUG_SERVER;  
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com'; 
    $mail->SMTPAuth   = true;
    $mail->Username   = 'irvan.reki2005@gmail.com'; 
    $mail->Password   = 'ztya puhs tnwm pnpz'; 
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; 
    $mail->Port       = 465; 

    // Pengirim
    $mail->setFrom('no-reply@gudang.com', 'Admin Gudang');
    
    // Konten
    $mail->isHTML(true);

} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>