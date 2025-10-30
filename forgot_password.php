<?php require 'includes/header.php'; ?>

<h2>Lupa Password</h2>
<p>Masukkan email Anda yang terdaftar. Kami akan mengirimkan tautan untuk me-reset password Anda.</p>

<form action="actions/handle_forgot_password.php" method="POST">
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>
    </div>
    <button type="submit" class="btn">Kirim Tautan Reset</button>
</form>

<?php require 'includes/footer.php'; ?>