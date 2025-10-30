<?php
require 'includes/auth_check.php'; // WAJIB! Cek apakah sudah login
require 'includes/header.php';     // Tampilkan header
?>

<h2>Dashboard Admin Gudang</h2>

<h3>Selamat Datang, <?php echo htmlspecialchars($_SESSION['user_email']); ?>!</h3>

<p>Anda telah berhasil login sebagai <?php echo htmlspecialchars($_SESSION['user_role']); ?>.</p>
<p>Dari sini Anda dapat mengelola produk dan profil Anda melalui menu navigasi di atas.</p>

<ul>
    <li><a href="products.php">Kelola Data Produk</a> (Operasi CRUD)</li>
    <li><a href="profile.php">Kelola Profil Anda</a> (Termasuk Ubah Password)</li>
</ul>

<?php require 'includes/footer.php'; // Tampilkan footer ?>