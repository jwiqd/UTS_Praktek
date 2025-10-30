<?php
// Mulai sesi di setiap halaman
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Gudang</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        nav { margin-bottom: 20px; background: #f4f4f4; padding: 10px; }
        nav a { margin-right: 15px; text-decoration: none; }
        .container { max-width: 800px; margin: auto; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; }
        .form-group input { width: 100%; padding: 8px; box-sizing: border-box; }
        .btn { padding: 10px 15px; background: #007bff; color: white; border: none; cursor: pointer; }
        .alert { padding: 15px; margin-bottom: 20px; border-radius: 5px; }
        .alert-success { background: #d4edda; color: #155724; }
        .alert-error { background: #f8d7da; color: #721c24; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background: #f2f2f2; }
    </style>
</head>
<body>

<div class="container">
    <nav>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="dashboard.php">Dashboard</a>
            <a href="products.php">Manajemen Produk</a>
            <a href="profile.php">Profil Saya</a>
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="index.php">Home</a>
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
        <?php endif; ?>
    </nav>

    <?php
    // Tampilkan pesan sukses (jika ada)
    if (isset($_SESSION['success_msg'])) {
        echo '<div class="alert alert-success">' . $_SESSION['success_msg'] . '</div>';
        unset($_SESSION['success_msg']); // Hapus pesan setelah ditampilkan
    }
    
    // Tampilkan pesan error (jika ada)
    if (isset($_SESSION['error_msg'])) {
        echo '<div class="alert alert-error">' . $_SESSION['error_msg'] . '</div>';
        unset($_SESSION['error_msg']); // Hapus pesan setelah ditampilkan
    }
    ?>