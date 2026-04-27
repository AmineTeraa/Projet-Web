<?php
require __DIR__ . '/../includes/init.php';

$productId = (int)($_POST['product_id'] ?? 0);
if ($productId <= 0) {
  header('Content-Type: application/json');
  echo json_encode(['count' => $cartCount]);
  exit;
}

if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
  $_SESSION['cart'] = [];
}

if (!isset($_SESSION['cart'][$productId])) {
  $_SESSION['cart'][$productId] = 0;
}
$_SESSION['cart'][$productId] += 1;

$count = 0;
foreach ($_SESSION['cart'] as $quantity) {
  $count += (int)$quantity;
}

header('Content-Type: application/json');
echo json_encode(['count' => $count]);
