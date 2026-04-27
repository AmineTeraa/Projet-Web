const productGrid = document.querySelector('#productGrid');
const productMessage = document.querySelector('#productMessage');
const searchInput = document.querySelector('#searchInput');
const categorySelect = document.querySelector('#categorySelect');
const sortSelect = document.querySelector('#sortSelect');
const minPrice = document.querySelector('#minPrice');
const maxPrice = document.querySelector('#maxPrice');
const minPriceValue = document.querySelector('#minPriceValue');
const maxPriceValue = document.querySelector('#maxPriceValue');
const cartCount = document.querySelector('#cartCount');

const loginForm = document.querySelector('#loginForm');
const registerForm = document.querySelector('#registerForm');

function updatePriceValues() {
  if (!minPrice || !maxPrice) {
    return;
  }

  let minVal = Number(minPrice.value);
  let maxVal = Number(maxPrice.value);

  if (minVal > maxVal - 20) {
    minVal = maxVal - 20;
    minPrice.value = minVal;
  }

  if (maxVal < minVal + 20) {
    maxVal = minVal + 20;
    maxPrice.value = maxVal;
  }

  minPriceValue.textContent = `$${minVal}`;
  maxPriceValue.textContent = `$${maxVal}`;
}

function buildQuery() {
  const params = new URLSearchParams();
  if (searchInput && searchInput.value.trim()) {
    params.set('search', searchInput.value.trim());
  }
  if (categorySelect && categorySelect.value) {
    params.set('category', categorySelect.value);
  }
  if (sortSelect && sortSelect.value) {
    params.set('sort', sortSelect.value);
  }
  if (minPrice && maxPrice) {
    params.set('minPrice', minPrice.value);
    params.set('maxPrice', maxPrice.value);
  }
  return params.toString();
}

async function loadProducts() {
  if (!productGrid) {
    return;
  }

  updatePriceValues();
  const query = buildQuery();
  const response = await fetch(`api/products.php?${query}`);
  const products = await response.json();

  if (!products.length) {
    productGrid.innerHTML = '';
    productMessage.textContent = 'No products found.';
    return;
  }

  productMessage.textContent = '';
  productGrid.innerHTML = products.map((product) => {
    const imageTag = product.image_url
      ? `<img src="${product.image_url}" alt="${product.name}">`
      : '<div class="img-placeholder"></div>';

    return `
      <article class="product-card">
        ${imageTag}
        <h3>${product.name}</h3>
        <p class="price">$${product.price}</p>
        <p class="category">${product.category_name}</p>
        <div class="card-actions">
          <a class="btn ghost" href="product.php?id=${product.id}">View</a>
          <button class="btn" type="button" data-add-to-cart="${product.id}">Add to cart</button>
        </div>
      </article>
    `;
  }).join('');
}

function attachProductListeners() {
  if (!productGrid) {
    return;
  }

  [searchInput, categorySelect, sortSelect, minPrice, maxPrice].forEach((el) => {
    if (el) {
      el.addEventListener('input', loadProducts);
      el.addEventListener('change', loadProducts);
    }
  });
}

function showMessage(target, message, isError) {
  if (!target) {
    return;
  }
  target.textContent = message;
  target.classList.toggle('error', Boolean(isError));
}

function updateCartCount(count) {
  if (!cartCount) {
    return;
  }
  cartCount.textContent = count;
}

async function addToCart(productId) {
  const response = await fetch('api/cart_add.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded',
    },
    body: `product_id=${encodeURIComponent(productId)}`,
  });
  const data = await response.json();
  updateCartCount(data.count);
  showMessage(productMessage, 'Added to cart.', false);
}

async function checkEmailAvailability(email) {
  const response = await fetch(`api/check_email.php?email=${encodeURIComponent(email)}`);
  const data = await response.json();
  return data.available;
}

function validateEmail(email) {
  return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}

function validateRegisterForm() {
  if (!registerForm) {
    return true;
  }

  const name = registerForm.querySelector('input[name="full_name"]');
  const email = registerForm.querySelector('input[name="email"]');
  const password = registerForm.querySelector('input[name="password"]');
  const confirm = registerForm.querySelector('input[name="confirm_password"]');
  const message = document.querySelector('#registerMessage');

  if (!name.value.trim() || !email.value.trim() || !password.value.trim() || !confirm.value.trim()) {
    showMessage(message, 'Please fill out all fields.', true);
    return false;
  }

  if (!validateEmail(email.value)) {
    showMessage(message, 'Please enter a valid email.', true);
    return false;
  }

  if (password.value.length < 6) {
    showMessage(message, 'Password must be at least 6 characters.', true);
    return false;
  }

  if (password.value !== confirm.value) {
    showMessage(message, 'Passwords do not match.', true);
    return false;
  }

  showMessage(message, 'Looks good.', false);
  return true;
}

if (registerForm) {
  registerForm.addEventListener('submit', async (event) => {
    event.preventDefault();
    if (!validateRegisterForm()) {
      return;
    }

    const email = document.querySelector('#registerEmail');
    const message = document.querySelector('#registerMessage');
    const available = await checkEmailAvailability(email.value.trim());
    if (!available) {
      showMessage(message, 'Email is already used.', true);
      return;
    }

    registerForm.submit();
  });
}

if (loginForm) {
  loginForm.addEventListener('submit', () => {
    const message = document.querySelector('#loginMessage');
    showMessage(message, '', false);
  });
}

if (productGrid) {
  attachProductListeners();
  loadProducts();
}

document.addEventListener('click', (event) => {
  const button = event.target.closest('[data-add-to-cart]');
  if (!button) {
    return;
  }
  event.preventDefault();
  const productId = button.getAttribute('data-add-to-cart');
  if (productId) {
    addToCart(productId);
  }
});
