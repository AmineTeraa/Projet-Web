<?php
require __DIR__ . '/includes/db.php';
require __DIR__ . '/includes/init.php';

$notice = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $action = $_POST['action'] ?? '';

  if ($action === 'update') {
    $quantities = $_POST['quantity'] ?? [];
    foreach ($quantities as $productId => $quantity) {
      $productId = (int)$productId;
      $quantity = (int)$quantity;
      if ($productId > 0) {
        if ($quantity <= 0) {
          unset($_SESSION['cart'][$productId]);
        } else {
          $_SESSION['cart'][$productId] = $quantity;
        }
      }
    }
    $notice = 'Cart updated.';
  }

  if ($action === 'clear') {
    $_SESSION['cart'] = [];
    $notice = 'Cart cleared.';
  }
}

$cartItems = $_SESSION['cart'] ?? [];
$productIds = array_keys($cartItems);
$products = [];

if ($productIds) {
  $placeholders = implode(',', array_fill(0, count($productIds), '?'));
  $stmt = $pdo->prepare("SELECT products.id, products.name, products.price, products.image_url, categories.name AS category_name FROM products JOIN categories ON categories.id = products.category_id WHERE products.id IN ($placeholders)");
  $stmt->execute($productIds);
  $products = $stmt->fetchAll();
}

$pageTitle = 'ElectroHub - Cart';
include __DIR__ . '/includes/header.php';
?>
<section class="container section">
  <h1>Your cart</h1>
  <?php if ($notice): ?>
    <p class="form-note"><?php echo htmlspecialchars($notice); ?></p>
  <?php endif; ?>

  <?php if (!$products): ?>
    <p>Your cart is empty. Explore <a href="products.php">products</a> to add items.</p>
  <?php else: ?>
    <form method="post" action="">
      <input type="hidden" name="action" value="update" />
      <div class="cart-list">
        <?php
        $total = 0;
        foreach ($products as $product):
          $qty = (int)($cartItems[$product['id']] ?? 0);
          $line = $qty * $product['price'];
          $total += $line;
        ?>
          <article class="cart-row">
            <div class="cart-info">
              <?php if ($product['image_url']): ?>
                <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" />
              <?php else: ?>
                <div class="img-placeholder"></div>
              <?php endif; ?>
              <div>
                <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                <p class="category"><?php echo htmlspecialchars($product['category_name']); ?></p>
              </div>
            </div>
            <div class="cart-qty">
              <label>Qty
                <input type="number" min="0" name="quantity[<?php echo $product['id']; ?>]" value="<?php echo $qty; ?>" />
              </label>
              <p class="price">$<?php echo number_format($line, 2); ?></p>
            </div>
          </article>
        <?php endforeach; ?>
      </div>
      <div class="cart-summary">
        <p>Total: <strong>$<?php echo number_format($total, 2); ?></strong></p>
        <div class="cart-actions">
          <button class="btn" type="submit">Update cart</button>
        </div>
      </div>
    </form>
    <form method="post" action="">
      <input type="hidden" name="action" value="clear" />
      <button class="btn ghost" type="submit">Clear cart</button>
    </form>
  <?php endif; ?>
</section>
<?php include __DIR__ . '/includes/footer.php'; ?>
