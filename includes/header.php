<?php
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
        <a href="auth.php">Login</a>
      </nav>
    </div>
  </header>
  <main class="site-main">
