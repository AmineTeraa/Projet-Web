<?php
$pageTitle = 'ElectroHub - Login';
include __DIR__ . '/includes/header.php';
?>
<section class="container section">
  <div class="auth-grid">
    <form id="loginForm" class="card" method="post" action="">
      <h2>Login</h2>
      <label>Email
        <input type="email" name="login_email" required />
      </label>
      <label>Password
        <input type="password" name="login_password" required />
      </label>
      <button class="btn" type="submit">Sign in</button>
      <p class="form-note" id="loginMessage"></p>
    </form>

    <form id="registerForm" class="card" method="post" action="">
      <h2>Create account</h2>
      <label>Full name
        <input type="text" name="full_name" required />
      </label>
      <label>Email
        <input type="email" name="email" id="registerEmail" required />
      </label>
      <label>Password
        <input type="password" name="password" id="registerPassword" required />
      </label>
      <label>Confirm password
        <input type="password" name="confirm_password" id="confirmPassword" required />
      </label>
      <button class="btn" type="submit">Create account</button>
      <p class="form-note" id="registerMessage"></p>
    </form>
  </div>
</section>
<?php include __DIR__ . '/includes/footer.php'; ?>
