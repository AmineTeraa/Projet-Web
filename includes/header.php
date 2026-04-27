<?php
require_once __DIR__ . '/init.php';

if (!isset($pageTitle)) {
  $pageTitle = 'Mini Shop';
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?php echo htmlspecialchars($pageTitle); ?></title>
  <link rel="stylesheet" href="assets/css/style.css" />
</head>
<body>
  <header class="site-header">
    <div class="container header-row">
      <a class="logo" href="index.php">ElectroHub</a>
      <nav class="nav">
        <a href="index.php">Home</a>
        <a href="products.php">Products</a>
        <a href="cart.php">Cart <span class="cart-count" id="cartCount"><?php echo $cartCount; ?></span></a>
        <?php if ($currentUser): ?>
          <span class="nav-user">Hi, <?php echo htmlspecialchars($currentUser['full_name']); ?></span>
          <a href="logout.php">Logout</a>
        <?php else: ?>
          <a href="auth.php">Login</a>
        <?php endif; ?>
      </nav>
    </div>
  </header>
  <main class="site-main">
