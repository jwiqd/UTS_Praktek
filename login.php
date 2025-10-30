<?php require 'includes/header.php'; ?>

<h2>Login</h2>
<p>Silakan login untuk masuk ke dashboard.</p>

<form action="actions/handle_login.php" method="POST">
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>
    </div>
    <button type="submit" class="btn">Login</button>
</form>
<br>
<a href="forgot_password.php">Lupa Password?</a>

<?php require 'includes/footer.php'; ?>    