<?php
require 'includes/auth_check.php'; // WAJIB!
require 'config/database.php';
require 'includes/header.php';

// Ambil data profil saat ini untuk ditampilkan di form
$stmt = $pdo->prepare("SELECT email, full_name FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();
?>

<h2>Profil Saya</h2>

<p>Email: <strong><?php echo htmlspecialchars($user['email']); ?></strong> (Tidak bisa diubah)</p>

<hr>

<h3>Ubah Data Profil</h3>
<form action="actions/handle_profile.php" method="POST">
    <input type="hidden" name="action" value="update_profile">
    <div class="form-group">
        <label for="full_name">Nama Lengkap</label>
        <input type="text" id="full_name" name="full_name" value="<?php echo htmlspecialchars($user['full_name'] ?? ''); ?>">
    </div>
    <button type="submit" class="btn">Simpan Perubahan Profil</button>
</form>

<hr>

<h3>Ubah Password</h3>
<form action="actions/handle_profile.php" method="POST">
    <input type="hidden" name="action" value="change_password">
    <div class="form-group">
        <label for="current_password">Password Saat Ini</label>
        <input type="password" id="current_password" name="current_password" required>
    </div>
    <div class="form-group">
        <label for="new_password">Password Baru</label>
        <input type="password" id="new_password" name="new_password" required>
    </div>
    <div class="form-group">
        <label for="confirm_password">Konfirmasi Password Baru</label>
        <input type="password" id="confirm_password" name="confirm_password" required>
    </div>
    <button type="submit" class="btn">Ubah Password</button>
</form>

<?php require 'includes/footer.php'; ?>