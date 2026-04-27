<?php
require __DIR__ . '/includes/db.php';
require __DIR__ . '/includes/init.php';

$pageTitle = 'ElectroHub - Login';
$loginMessage = '';
$registerMessage = '';
$loginIsError = false;
$registerIsError = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $action = $_POST['action'] ?? '';

  if ($action === 'register') {
    $fullName = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';

    if ($fullName === '' || $email === '' || $password === '' || $confirm === '') {
      $registerMessage = 'Please fill out all fields.';
      $registerIsError = true;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $registerMessage = 'Please enter a valid email.';
      $registerIsError = true;
    } elseif (strlen($password) < 6) {
      $registerMessage = 'Password must be at least 6 characters.';
      $registerIsError = true;
    } elseif ($password !== $confirm) {
      $registerMessage = 'Passwords do not match.';
      $registerIsError = true;
    } else {
      $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ? LIMIT 1');
      $stmt->execute([$email]);
      if ($stmt->fetch()) {
        $registerMessage = 'Email already used.';
        $registerIsError = true;
      } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare('INSERT INTO users (full_name, email, password_hash) VALUES (?, ?, ?)');
        $stmt->execute([$fullName, $email, $hash]);
        $_SESSION['user'] = [
          'full_name' => $fullName,
          'email' => $email,
        ];
        header('Location: index.php');
        exit;
      }
    }
  }

  if ($action === 'login') {
    $email = trim($_POST['login_email'] ?? '');
    $password = $_POST['login_password'] ?? '';

    if ($email === '' || $password === '') {
      $loginMessage = 'Enter your email and password.';
      $loginIsError = true;
    } else {
      $stmt = $pdo->prepare('SELECT full_name, email, password_hash FROM users WHERE email = ? LIMIT 1');
      $stmt->execute([$email]);
      $user = $stmt->fetch();

      if (!$user || !password_verify($password, $user['password_hash'])) {
        $loginMessage = 'Invalid email or password.';
        $loginIsError = true;
      } else {
        $_SESSION['user'] = [
          'full_name' => $user['full_name'],
          'email' => $user['email'],
        ];
        header('Location: index.php');
        exit;
      }
    }
  }
}

include __DIR__ . '/includes/header.php';
?>
<section class="container section">
  <div class="auth-grid">
    <form id="loginForm" class="card" method="post" action="">
      <input type="hidden" name="action" value="login" />
      <h2>Login</h2>
      <label>Email
        <input type="email" name="login_email" required />
      </label>
      <label>Password
        <input type="password" name="login_password" required />
      </label>
      <button class="btn" type="submit">Sign in</button>
      <p class="form-note <?php echo $loginIsError ? 'error' : ''; ?>" id="loginMessage">
        <?php echo htmlspecialchars($loginMessage); ?>
      </p>
    </form>

    <form id="registerForm" class="card" method="post" action="">
      <input type="hidden" name="action" value="register" />
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
      <p class="form-note <?php echo $registerIsError ? 'error' : ''; ?>" id="registerMessage">
        <?php echo htmlspecialchars($registerMessage); ?>
      </p>
    </form>
  </div>
</section>
<?php include __DIR__ . '/includes/footer.php'; ?>
