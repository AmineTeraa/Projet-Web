<?php
require __DIR__ . '/../includes/db.php';

$email = trim($_GET['email'] ?? '');
$isValid = filter_var($email, FILTER_VALIDATE_EMAIL);

$available = false;
if ($isValid) {
  $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ? LIMIT 1');
  $stmt->execute([$email]);
  $available = $stmt->fetch() ? false : true;
}

header('Content-Type: application/json');
echo json_encode([
  'available' => $available,
]);
