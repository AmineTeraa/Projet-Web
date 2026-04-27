<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

$cartCount = 0;
if (!empty($_SESSION['cart']) && is_array($_SESSION['cart'])) {
  foreach ($_SESSION['cart'] as $quantity) {
    $cartCount += (int)$quantity;
  }
}

$currentUser = $_SESSION['user'] ?? null;
