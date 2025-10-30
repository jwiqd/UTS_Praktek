<?php
require 'config/database.php';
require 'includes/header.php';


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
    
?>
    <h2>Token Tidak Valid</h2>
    <p>Tautan reset password ini tidak valid atau telah kedaluwarsa. Silakan coba lagi melalui halaman Lupa Password.</p>
    <?php
    ?>

<?php
else:
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
endif; 

require 'includes/footer.php';
?>