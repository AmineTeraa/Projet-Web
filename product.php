<?php
require __DIR__ . '/includes/db.php';
require __DIR__ . '/includes/init.php';

$productId = (int)($_GET['id'] ?? 0);
$product = null;

if ($productId > 0) {
  $stmt = $pdo->prepare('SELECT products.id, products.name, products.price, products.image_url, categories.name AS category_name FROM products JOIN categories ON categories.id = products.category_id WHERE products.id = ?');
  $stmt->execute([$productId]);
  $product = $stmt->fetch();
}

$pageTitle = $product ? 'ElectroHub - ' . $product['name'] : 'ElectroHub - Product';
include __DIR__ . '/includes/header.php';
?>
<section class="container section">
  <?php if (!$product): ?>
    <p>Product not found. Return to <a href="products.php">products</a>.</p>
  <?php else: ?>
    <div class="product-detail">
      <div class="product-media">
        <?php if ($product['image_url']): ?>
          <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" />
        <?php else: ?>
          <div class="img-placeholder"></div>
        <?php endif; ?>
      </div>
      <div class="product-info">
        <p class="category">Category: <?php echo htmlspecialchars($product['category_name']); ?></p>
        <h1><?php echo htmlspecialchars($product['name']); ?></h1>
        <p class="price">$<?php echo number_format($product['price'], 2); ?></p>
        <p>Performance tuned for modern work and play. Designed for speed, clarity, and daily comfort.</p>
        <button class="btn" type="button" data-add-to-cart="<?php echo $product['id']; ?>">Add to cart</button>
      </div>
    </div>
  <?php endif; ?>
</section>
<?php include __DIR__ . '/includes/footer.php'; ?>
