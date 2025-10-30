<?php
require 'config/database.php';
require 'includes/header.php';

// PAKSA ZONA WAKTU (WIB) - Perbaikan Final
date_default_timezone_set('Asia/Jakarta');

$token = $_GET['token'] ?? null;
$user = null;

if ($token) {
    // 1. Ambil waktu PHP saat ini (yang sudah dipaksa ke WIB)
    $current_time_php = date('Y-m-d H:i:s');

    // 2. Cek token dan bandingkan dengan waktu PHP
    $stmt = $pdo->prepare("SELECT id FROM users WHERE reset_token = ? AND reset_token_expiry > ?");
    $stmt->execute([$token, $current_time_php]);
    $user = $stmt->fetch();
}

if (!$user):
    // --- INI BAGIAN YANG ANDA LIHAT ---
    // Jika $user false (token tidak cocok ATAU waktu habis), tampilkan error
?>
    <h2>Token Tidak Valid</h2>
    <p>Tautan reset password ini tidak valid atau telah kedaluwarsa. Silakan coba lagi melalui halaman Lupa Password.</p>
    <?php
    // (Opsional: Tampilkan debug)
    // echo "<p>Debug: Token di URL: " . htmlspecialchars($token) . "</p>";
    // echo "<p>Debug: Waktu PHP Saat Ini: " . $current_time_php . "</p>";
    ?>

<?php
else:
    // --- INI BAGIAN YANG SEHARUSNYA MUNCUL ---
    // Jika $user DITEMUKAN (token valid), tampilkan form
?>
    <h2>Buat Password Baru</h2>
    <p>Silakan masukkan password baru Anda.</p>

    <form action="actions/handle_reset_password.php" method="POST">
        <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
        
        <div class="form-group">
            <label for="new_password">Password Baru</label>
            <input type="password" id="new_password" name="new_password" required>
        </div>
        <div class="form-group">
            <label for="confirm_password">Konfirmasi Password Baru</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
        </div>
        <button type="submit" class="btn">Reset Password</button>
    </form>

<?php
endif; // Penutup if ($user)

require 'includes/footer.php';
?>