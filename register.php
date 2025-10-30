<?php require 'includes/header.php'; ?>

<h2>Registrasi Admin Gudang</h2>
<p>Daftarkan akun baru Anda.</p>

<form action="actions/handle_register.php" method="POST">
    <div class="form-group">
        <label for="email">Email (Username)</label>
        <input type="email" id="email" name="email" required>
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>
    </div>
    <button type="submit" class="btn">Register</button>
</form>

<?php require 'includes/footer.php'; ?>