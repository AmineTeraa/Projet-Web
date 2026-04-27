<?php
$pageTitle = 'ElectroHub - Home';
include __DIR__ . '/includes/header.php';
?>
<section class="hero">
  <div class="container hero-grid">
    <div>
      <h1>Electronics that fit your life.</h1>
      <p>Discover laptops, phones, and accessories curated for speed and style.</p>
      <a class="btn" href="products.php">Browse products</a>
    </div>
    <div class="hero-card">
      <h2>Featured picks</h2>
      <ul>
        <li>Ultra-light laptops</li>
        <li>Flagship phones</li>
        <li>Smart accessories</li>
      </ul>
    </div>
  </div>
</section>

<section class="container section">
  <h2>Shop by category</h2>
  <div class="card-grid">
    <article class="category-card">
      <h3>Laptops</h3>
      <p>Power and portability.</p>
      <a href="products.php?category=1">Explore</a>
    </article>
    <article class="category-card">
      <h3>Phones</h3>
      <p>Capture and connect.</p>
      <a href="products.php?category=2">Explore</a>
    </article>
    <article class="category-card">
      <h3>Accessories</h3>
      <p>Smart extras for every day.</p>
      <a href="products.php?category=3">Explore</a>
    </article>
  </div>
</section>
<?php include __DIR__ . '/includes/footer.php'; ?>
