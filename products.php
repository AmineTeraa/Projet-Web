<?php
require __DIR__ . '/includes/db.php';
$pageTitle = 'ElectroHub - Products';

$actionMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $action = $_POST['action'] ?? '';

  if ($action === 'add') {
    $name = trim($_POST['name'] ?? '');
    $price = (float)($_POST['price'] ?? 0);
    $imageUrl = trim($_POST['image_url'] ?? '');
    $categoryId = (int)($_POST['category_id'] ?? 0);

    if ($name !== '' && $price > 0 && $categoryId > 0) {
      $stmt = $pdo->prepare('INSERT INTO products (name, price, image_url, category_id) VALUES (?, ?, ?, ?)');
      $stmt->execute([$name, $price, $imageUrl, $categoryId]);
      $actionMessage = 'Product added.';
    }
  }

  if ($action === 'delete') {
    $productId = (int)($_POST['product_id'] ?? 0);
    if ($productId > 0) {
      $stmt = $pdo->prepare('DELETE FROM products WHERE id = ?');
      $stmt->execute([$productId]);
      $actionMessage = 'Product removed.';
    }
  }

  if ($action === 'update') {
    $productId = (int)($_POST['product_id'] ?? 0);
    $name = trim($_POST['name'] ?? '');
    $price = (float)($_POST['price'] ?? 0);
    $categoryId = (int)($_POST['category_id'] ?? 0);

    if ($productId > 0 && $name !== '' && $price > 0 && $categoryId > 0) {
      $stmt = $pdo->prepare('UPDATE products SET name = ?, price = ?, category_id = ? WHERE id = ?');
      $stmt->execute([$name, $price, $categoryId, $productId]);
      $actionMessage = 'Product updated.';
    }
  }
}

$categories = $pdo->query('SELECT id, name FROM categories ORDER BY name')->fetchAll();
$manageProducts = $pdo->query('SELECT products.id, products.name, products.price, products.category_id, categories.name AS category_name FROM products JOIN categories ON categories.id = products.category_id ORDER BY products.id DESC')->fetchAll();
$selectedCategory = (int)($_GET['category'] ?? 0);

include __DIR__ . '/includes/header.php';
?>
<section class="container section">
  <h1>Products</h1>
  <div class="filters">
    <label>Search
      <input type="search" id="searchInput" placeholder="Search laptops, phones..." />
    </label>
    <label>Category
      <select id="categorySelect">
        <option value="">All</option>
        <?php foreach ($categories as $category): ?>
          <option value="<?php echo $category['id']; ?>" <?php echo $selectedCategory === (int)$category['id'] ? 'selected' : ''; ?>>
            <?php echo htmlspecialchars($category['name']); ?>
          </option>
        <?php endforeach; ?>
      </select>
    </label>
    <label>Sort by
      <select id="sortSelect">
        <option value="latest">Latest</option>
        <option value="price_asc">Price low to high</option>
        <option value="price_desc">Price high to low</option>
        <option value="name_asc">Name A-Z</option>
      </select>
    </label>
    <div class="price-range">
      <label>Min
        <input type="range" id="minPrice" min="0" max="2000" step="10" value="0" />
      </label>
      <label>Max
        <input type="range" id="maxPrice" min="0" max="2000" step="10" value="2000" />
      </label>
      <div class="price-display">
        <span id="minPriceValue">$0</span> - <span id="maxPriceValue">$2000</span>
      </div>
    </div>
  </div>
  <div id="productGrid" class="product-grid"></div>
  <p id="productMessage" class="form-note"></p>
</section>

<section class="container section">
  <h2>Manage products (CRUD)</h2>
  <?php if ($actionMessage): ?>
    <p class="form-note"><?php echo htmlspecialchars($actionMessage); ?></p>
  <?php endif; ?>
  <form class="card" method="post" action="">
    <input type="hidden" name="action" value="add" />
    <label>Product name
      <input type="text" name="name" required />
    </label>
    <label>Price
      <input type="number" name="price" min="1" step="0.01" required />
    </label>
    <label>Image URL
      <input type="text" name="image_url" placeholder="assets/img/laptop-1.jpg" />
    </label>
    <label>Category
      <select name="category_id" required>
        <?php foreach ($categories as $category): ?>
          <option value="<?php echo $category['id']; ?>"><?php echo htmlspecialchars($category['name']); ?></option>
        <?php endforeach; ?>
      </select>
    </label>
    <button class="btn" type="submit">Add product</button>
  </form>

  <div class="manage-list">
    <?php foreach ($manageProducts as $product): ?>
      <form class="manage-row" method="post" action="">
        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>" />
        <input type="hidden" name="action" value="update" />
        <input type="text" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required />
        <input type="number" name="price" min="1" step="0.01" value="<?php echo $product['price']; ?>" required />
        <select name="category_id" required>
          <?php foreach ($categories as $category): ?>
            <option value="<?php echo $category['id']; ?>" <?php echo $category['id'] == $product['category_id'] ? 'selected' : ''; ?>>
              <?php echo htmlspecialchars($category['name']); ?>
            </option>
          <?php endforeach; ?>
        </select>
        <button class="btn" type="submit">Update</button>
      </form>
      <form class="manage-row" method="post" action="">
        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>" />
        <input type="hidden" name="action" value="delete" />
        <button class="btn danger" type="submit">Delete</button>
      </form>
    <?php endforeach; ?>
  </div>
</section>
<?php include __DIR__ . '/includes/footer.php'; ?>
