<?php
require __DIR__ . '/../includes/db.php';

$search = trim($_GET['search'] ?? '');
$category = (int)($_GET['category'] ?? 0);
$sort = $_GET['sort'] ?? 'latest';
$minPrice = (float)($_GET['minPrice'] ?? 0);
$maxPrice = (float)($_GET['maxPrice'] ?? 2000);

$allowedSorts = [
  'latest' => 'products.created_at DESC',
  'price_asc' => 'products.price ASC',
  'price_desc' => 'products.price DESC',
  'name_asc' => 'products.name ASC',
];
$orderBy = $allowedSorts[$sort] ?? $allowedSorts['latest'];

$where = [];
$params = [];

if ($search !== '') {
  $where[] = 'products.name LIKE ?';
  $params[] = '%' . $search . '%';
}

if ($category > 0) {
  $where[] = 'products.category_id = ?';
  $params[] = $category;
}

$where[] = 'products.price BETWEEN ? AND ?';
$params[] = $minPrice;
$params[] = $maxPrice;

$sql = 'SELECT products.id, products.name, products.price, products.image_url, categories.name AS category_name FROM products JOIN categories ON categories.id = products.category_id';
if ($where) {
  $sql .= ' WHERE ' . implode(' AND ', $where);
}
$sql .= ' ORDER BY ' . $orderBy;

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$products = $stmt->fetchAll();

header('Content-Type: application/json');
echo json_encode($products);
