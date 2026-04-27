<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>POS Sale — OWERU</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;0,700&family=Syne:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
:root {
  --ink: #0C0F14; --ink-soft: #1A1F2B; --ink-muted: #3D4455;
  --paper: #F5F2EC; --paper-2: #EDE9E0; --cream: #FAF8F4;
  --gold: #B8963E; --gold-lt: #D4AF5E; --gold-pale: #F2EAD6;
  --white: #FFFFFF; --slate: #6B7385; --border: rgba(12,15,20,0.1);
  --f-sans: 'Syne', sans-serif;
  --ease: cubic-bezier(0.25, 0.46, 0.45, 0.94);
}
*, *::before, *::after { margin:0; padding:0; box-sizing:border-box; }
html { scroll-behavior: smooth; }
body { font-family: var(--f-sans); background: var(--cream); color: var(--ink); -webkit-font-smoothing: antialiased; }
a { text-decoration: none; color: inherit; }
.container { max-width: 1400px; margin: 0 auto; padding: 0 24px; }

/* Header */
.header { position: sticky; top: 0; z-index: 500; background: rgba(245,242,236,0.96); backdrop-filter: blur(20px); border-bottom: 1px solid var(--border); }
.header__row { display: flex; align-items: center; justify-content: space-between; height: 60px; }
.logo { display: flex; align-items: center; gap: 10px; }
.logo__mark { width: 32px; height: 32px; background: var(--ink); border-radius: 4px; display: flex; align-items: center; justify-content: center; }
.logo__name { font-family: var(--f-sans); font-size: 14px; font-weight: 800; letter-spacing: 2px; color: var(--ink); }
.back-link { font-size: 12px; font-weight: 600; letter-spacing: 0.8px; color: var(--ink-muted); text-transform: uppercase; transition: color 0.2s; }
.back-link:hover { color: var(--gold); }

/* Layout */
.pos-layout { display: grid; grid-template-columns: 1fr 380px; gap: 24px; padding: 24px 0; min-height: calc(100vh - 60px); }

/* Product area */
.product-area { background: var(--white); border: 1px solid var(--border); border-radius: 3px; padding: 24px; }
.search-bar { display: flex; align-items: center; gap: 10px; background: var(--paper); border: 1px solid var(--border); border-radius: 3px; padding: 0 14px; margin-bottom: 20px; }
.search-bar input { flex: 1; border: none; background: transparent; padding: 12px 0; font-size: 14px; font-family: var(--f-sans); outline: none; }
.search-bar i { color: var(--slate); }
.btn-add-product { display: inline-flex; align-items: center; gap: 6px; padding: 8px 14px; background: var(--ink); color: var(--white); border: none; border-radius: 3px; font-family: var(--f-sans); font-size: 12px; font-weight: 700; letter-spacing: 0.5px; text-transform: uppercase; cursor: pointer; transition: all 0.2s; white-space: nowrap; }
.btn-add-product:hover { background: var(--gold); color: var(--ink); }
.btn-add-product i { color: inherit; font-size: 11px; }
.products-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 16px; max-height: calc(100vh - 200px); overflow-y: auto; padding-right: 4px; }
.product-card { background: var(--cream); border: 1px solid var(--border); border-radius: 3px; padding: 16px; cursor: pointer; transition: all 0.2s; text-align: center; position: relative; }
.product-card:hover { border-color: var(--gold); transform: translateY(-2px); box-shadow: 0 8px 24px rgba(12,15,20,0.06); }
.product-card.out-of-stock { opacity: 0.5; pointer-events: none; }
.product-card .stock-badge { position: absolute; top: 8px; right: 8px; font-size: 10px; font-weight: 700; background: var(--gold-pale); color: var(--gold); padding: 2px 8px; border-radius: 20px; }
.product-card h4 { font-size: 13px; font-weight: 600; color: var(--ink); margin-bottom: 6px; line-height: 1.3; }
.product-card .price { font-size: 15px; font-weight: 700; color: var(--gold); }
.product-card .add-icon { width: 32px; height: 32px; background: var(--ink); color: var(--white); border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; margin-top: 10px; font-size: 12px; transition: all 0.2s; }
.product-card:hover .add-icon { background: var(--gold); color: var(--ink); }

/* Cart area */
.cart-area { background: var(--white); border: 1px solid var(--border); border-radius: 3px; display: flex; flex-direction: column; height: calc(100vh - 108px); position: sticky; top: 84px; }
.cart-header { padding: 20px; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; }
.cart-header h3 { font-size: 14px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; }
.cart-header .clear { font-size: 11px; color: var(--slate); cursor: pointer; transition: color 0.2s; }
.cart-header .clear:hover { color: var(--danger); }
.cart-items { flex: 1; overflow-y: auto; padding: 16px; }
.cart-item { display: flex; align-items: center; gap: 12px; padding: 12px 0; border-bottom: 1px solid var(--border); }
.cart-item .name { flex: 1; font-size: 13px; font-weight: 600; }
.cart-item .qty-controls { display: flex; align-items: center; gap: 6px; }
.cart-item .qty-btn { width: 24px; height: 24px; border: 1px solid var(--border); background: var(--white); border-radius: 3px; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 11px; transition: all 0.2s; }
.cart-item .qty-btn:hover { background: var(--ink); color: var(--white); border-color: var(--ink); }
.cart-item .qty { font-size: 12px; font-weight: 700; min-width: 20px; text-align: center; }
.cart-item .price { font-size: 13px; font-weight: 700; color: var(--gold); min-width: 60px; text-align: right; }
.cart-item .remove { font-size: 11px; color: var(--slate); cursor: pointer; margin-left: 4px; }
.cart-item .remove:hover { color: #DC2626; }
.empty-cart { text-align: center; padding: 40px 20px; color: var(--slate); font-size: 13px; }
.empty-cart i { font-size: 28px; margin-bottom: 12px; display: block; color: var(--border); }

/* Calculator */
.calculator-toggle { font-size: 11px; color: var(--slate); cursor: pointer; transition: color 0.2s; display: flex; align-items: center; gap: 4px; }
.calculator-toggle:hover { color: var(--gold); }
.calculator-panel { padding: 16px 20px; border-top: 1px solid var(--border); background: var(--cream); display: none; }
.calculator-panel.active { display: block; }
.calc-display { background: var(--white); border: 1px solid var(--border); border-radius: 3px; padding: 10px 12px; font-size: 18px; font-weight: 700; text-align: right; color: var(--ink); margin-bottom: 10px; min-height: 44px; word-break: break-all; }
.calc-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 6px; }
.calc-btn { padding: 10px 0; border: 1px solid var(--border); background: var(--white); border-radius: 3px; font-family: var(--f-sans); font-size: 14px; font-weight: 600; color: var(--ink); cursor: pointer; transition: all 0.15s; }
.calc-btn:hover { background: var(--paper-2); border-color: var(--gold); }
.calc-btn:active { transform: scale(0.97); }
.calc-btn--gold { background: var(--gold); color: var(--ink); border-color: var(--gold); }
.calc-btn--gold:hover { background: var(--gold-lt); }
.calc-btn--dark { background: var(--ink); color: var(--white); border-color: var(--ink); }
.calc-btn--dark:hover { background: var(--ink-muted); border-color: var(--ink-muted); }
.calc-btn--wide { grid-column: span 2; }

/* Cart footer */
.cart-footer { padding: 20px; border-top: 1px solid var(--border); background: var(--paper); }
.totals { margin-bottom: 16px; }
.total-row { display: flex; justify-content: space-between; font-size: 13px; margin-bottom: 8px; color: var(--ink-muted); }
.total-row.grand { font-size: 16px; font-weight: 700; color: var(--ink); padding-top: 8px; border-top: 1px solid var(--border); }
.btn-checkout { width: 100%; padding: 14px; background: var(--gold); color: var(--ink); border: none; border-radius: 3px; font-family: var(--f-sans); font-size: 12px; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; cursor: pointer; transition: all 0.25s; }
.btn-checkout:hover { background: var(--gold-lt); transform: translateY(-1px); box-shadow: 0 8px 24px rgba(184,150,62,0.35); }
.btn-checkout:disabled { background: var(--border); color: var(--slate); cursor: not-allowed; transform: none; box-shadow: none; }

/* Modal */
.modal-overlay { position: fixed; inset: 0; background: rgba(12,15,20,0.6); backdrop-filter: blur(8px); display: none; align-items: center; justify-content: center; z-index: 1000; padding: 24px; }
.modal-overlay.active { display: flex; }
.modal-box { background: var(--white); width: 100%; max-width: 460px; border-radius: 3px; box-shadow: 0 40px 80px rgba(12,15,20,0.3); padding: 32px; animation: modal-in 0.3s var(--ease); }
@keyframes modal-in { from { opacity: 0; transform: scale(0.96) translateY(16px); } to { opacity: 1; transform: scale(1) translateY(0); } }
.modal-box h3 { font-family: 'Cormorant Garamond', serif; font-size: 1.5rem; font-weight: 600; margin-bottom: 20px; }
.form-group { margin-bottom: 16px; }
.form-group label { display: block; font-size: 11px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; color: var(--ink-muted); margin-bottom: 6px; }
.form-group input, .form-group select { width: 100%; padding: 10px 12px; border: 1px solid var(--border); border-radius: 3px; font-family: var(--f-sans); font-size: 14px; outline: none; transition: border-color 0.2s; }
.form-group input:focus, .form-group select:focus { border-color: var(--gold); }
.modal-actions { display: flex; gap: 10px; margin-top: 24px; }
.modal-actions button { flex: 1; padding: 12px; border-radius: 3px; font-family: var(--f-sans); font-size: 12px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; cursor: pointer; transition: all 0.2s; border: none; }
.btn-cancel { background: var(--paper); color: var(--ink-muted); border: 1px solid var(--border); }
.btn-cancel:hover { background: var(--border); }
.btn-confirm { background: var(--ink); color: var(--white); }
.btn-confirm:hover { background: var(--gold); color: var(--ink); }

/* Alert */
.alert { padding: 12px 16px; border-radius: 3px; font-size: 13px; margin-bottom: 16px; display: none; }
.alert.error { background: #FEF2F2; color: #DC2626; border-left: 3px solid #DC2626; }
.alert.success { background: #ECFDF5; color: #059669; border-left: 3px solid #059669; }

@media (max-width: 900px) {
  .pos-layout { grid-template-columns: 1fr; }
  .cart-area { height: auto; position: static; }
  .products-grid { max-height: none; }
}
</style>
</head>
<body>

<header class="header">
  <div class="container">
    <div class="header__row">
      <a href="/" class="logo">
        <div class="logo__mark">
          <svg width="18" height="18" viewBox="0 0 20 20" fill="none"><path d="M3 15 L7 5 L10 10 L13 7 L17 15" stroke="#C9A84C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </div>
        <span class="logo__name">OWERU POS</span>
      </a>
      <div style="display:flex;gap:16px;align-items:center;">
        <a href="{{ route('pos.single-shop') }}" class="back-link">← Dashboard</a>
        <a href="/" class="back-link">Home</a>
      </div>
    </div>
  </div>
</header>

<div class="container">
  <div class="pos-layout">
    <!-- Products -->
    <div class="product-area">
      <div class="search-bar">
        <i class="fas fa-search"></i>
        <input type="text" id="productSearch" placeholder="Search products by name...">
        <button class="btn-add-product" onclick="openAddProductModal()">
          <i class="fas fa-plus"></i> Add Product
        </button>
      </div>
      <div class="alert error" id="alertBox"></div>
      <div class="products-grid" id="productsGrid">
        @forelse($products as $product)
          <div class="product-card {{ $product->stock <= 0 ? 'out-of-stock' : '' }}" 
               data-id="{{ $product->id }}" 
               data-name="{{ $product->name }}" 
               data-price="{{ $product->price_sale }}"
               data-stock="{{ $product->stock }}">
            @if($product->stock > 0)
              <span class="stock-badge">{{ $product->stock }} in stock</span>
            @else
              <span class="stock-badge" style="background:#FEF2F2;color:#DC2626;">Out of stock</span>
            @endif
            <h4>{{ $product->name }}</h4>
            <div class="price">${{ number_format($product->price_sale, 2) }}</div>
            @if($product->stock > 0)
              <div class="add-icon"><i class="fas fa-plus"></i></div>
            @endif
          </div>
        @empty
          <div style="grid-column:1/-1;text-align:center;padding:40px;color:var(--slate);font-size:14px;">
            <i class="fas fa-box-open" style="font-size:32px;margin-bottom:12px;display:block;color:var(--border);"></i>
            No products available for sale.
          </div>
        @endforelse
      </div>
    </div>

    <!-- Cart -->
    <div class="cart-area">
      <div class="cart-header">
        <h3><i class="fas fa-shopping-cart" style="margin-right:8px;color:var(--gold);"></i>Current Sale</h3>
        <div style="display:flex;gap:12px;align-items:center;">
          <span class="calculator-toggle" onclick="toggleCalculator()"><i class="fas fa-calculator"></i> Calc</span>
          <span class="clear" onclick="clearCart()"><i class="fas fa-trash-alt"></i> Clear</span>
        </div>
      </div>
      <div class="cart-items" id="cartItems">
        <div class="empty-cart">
          <i class="fas fa-shopping-basket"></i>
          <p>Tap a product to add it to the cart</p>
        </div>
      </div>
      <div class="calculator-panel" id="calculatorPanel">
        <div class="calc-display" id="calcDisplay">0</div>
        <div class="calc-grid">
          <button class="calc-btn calc-btn--dark" onclick="calcClear()">C</button>
          <button class="calc-btn calc-btn--dark" onclick="calcBackspace()">⌫</button>
          <button class="calc-btn" onclick="calcOp('/')">÷</button>
          <button class="calc-btn" onclick="calcOp('*')">×</button>
          <button class="calc-btn" onclick="calcNum('7')">7</button>
          <button class="calc-btn" onclick="calcNum('8')">8</button>
          <button class="calc-btn" onclick="calcNum('9')">9</button>
          <button class="calc-btn" onclick="calcOp('-')">−</button>
          <button class="calc-btn" onclick="calcNum('4')">4</button>
          <button class="calc-btn" onclick="calcNum('5')">5</button>
          <button class="calc-btn" onclick="calcNum('6')">6</button>
          <button class="calc-btn" onclick="calcOp('+')">+</button>
          <button class="calc-btn" onclick="calcNum('1')">1</button>
          <button class="calc-btn" onclick="calcNum('2')">2</button>
          <button class="calc-btn" onclick="calcNum('3')">3</button>
          <button class="calc-btn calc-btn--gold" onclick="calcEquals()" style="grid-row:span 2;">=</button>
          <button class="calc-btn calc-btn--wide" onclick="calcNum('0')">0</button>
          <button class="calc-btn" onclick="calcNum('.')">.</button>
        </div>
      </div>
      <div class="cart-footer">
        <div class="totals">
          <div class="total-row"><span>Subtotal</span><span id="subtotal">$0.00</span></div>
          <div class="total-row"><span>Tax (18%)</span><span id="tax">$0.00</span></div>
          <div class="total-row grand"><span>Total</span><span id="total">$0.00</span></div>
        </div>
        <button class="btn-checkout" id="checkoutBtn" onclick="openCheckout()" disabled>
          <i class="fas fa-credit-card" style="margin-right:8px;"></i> Checkout
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Checkout Modal -->
<div class="modal-overlay" id="checkoutModal">
  <div class="modal-box">
    <h3>Complete Sale</h3>
    <div class="alert error" id="modalAlert"></div>
    <div class="form-group">
      <label>Payment Method</label>
      <select id="paymentMethod">
        <option value="cash">Cash</option>
        <option value="card">Card</option>
        <option value="mobile_money">Mobile Money</option>
      </select>
    </div>
    <div class="form-group">
      <label>Amount Paid</label>
      <input type="number" id="amountPaid" step="0.01" min="0">
    </div>
    <div class="form-group">
      <label>Customer Name (optional)</label>
      <input type="text" id="customerName" placeholder="Walk-in customer">
    </div>
    <div class="form-group">
      <label>Customer Phone (optional)</label>
      <input type="text" id="customerPhone" placeholder="+255...">
    </div>
    <div class="form-group">
      <label>Notes (optional)</label>
      <input type="text" id="notes" placeholder="Any notes...">
    </div>
    <div class="modal-actions">
      <button class="btn-cancel" onclick="closeCheckout()">Cancel</button>
      <button class="btn-confirm" onclick="processCheckout()">Complete Sale</button>
    </div>
  </div>
</div>

<!-- Quick Add Product Modal -->
<div class="modal-overlay" id="addProductModal">
  <div class="modal-box">
    <h3>Add New Product</h3>
    <div class="alert error" id="addProductAlert"></div>
    <div class="form-group">
      <label>Product Name *</label>
      <input type="text" id="newProductName" placeholder="e.g. Cement Bag">
    </div>
    <div class="form-group">
      <label>Price ($) *</label>
      <input type="number" id="newProductPrice" step="0.01" min="0" placeholder="0.00">
    </div>
    <div class="form-group">
      <label>Stock Quantity *</label>
      <input type="number" id="newProductStock" min="0" value="1">
    </div>
    <div class="form-group">
      <label>Category</label>
      <select id="newProductCategory">
        <option value="General">General</option>
        <option value="Building Materials">Building Materials</option>
        <option value="Tools">Tools</option>
        <option value="Equipment">Equipment</option>
        <option value="Furniture">Furniture</option>
        <option value="Appliances">Appliances</option>
        <option value="Decor">Decor</option>
        <option value="Other">Other</option>
      </select>
    </div>
    <div class="modal-actions">
      <button class="btn-cancel" onclick="closeAddProductModal()">Cancel</button>
      <button class="btn-confirm" onclick="submitQuickAddProduct()">Add Product</button>
    </div>
  </div>
</div>

<script>
const products = @json($products);
let cart = [];

function formatMoney(amount) {
  return '$' + parseFloat(amount).toFixed(2);
}

function showAlert(msg, type = 'error') {
  const box = document.getElementById('alertBox');
  box.textContent = msg;
  box.className = 'alert ' + type;
  box.style.display = 'block';
  setTimeout(() => box.style.display = 'none', 4000);
}

function showModalAlert(msg) {
  const box = document.getElementById('modalAlert');
  box.textContent = msg;
  box.style.display = 'block';
}

function renderCart() {
  const container = document.getElementById('cartItems');
  if (cart.length === 0) {
    container.innerHTML = `
      <div class="empty-cart">
        <i class="fas fa-shopping-basket"></i>
        <p>Tap a product to add it to the cart</p>
      </div>`;
    document.getElementById('checkoutBtn').disabled = true;
    updateTotals();
    return;
  }

  container.innerHTML = cart.map((item, index) => `
    <div class="cart-item">
      <div class="name">${item.name}</div>
      <div class="qty-controls">
        <button class="qty-btn" onclick="changeQty(${index}, -1)"><i class="fas fa-minus"></i></button>
        <span class="qty">${item.qty}</span>
        <button class="qty-btn" onclick="changeQty(${index}, 1)"><i class="fas fa-plus"></i></button>
      </div>
      <div class="price">${formatMoney(item.price * item.qty)}</div>
      <div class="remove" onclick="removeItem(${index})"><i class="fas fa-times"></i></div>
    </div>
  `).join('');

  document.getElementById('checkoutBtn').disabled = false;
  updateTotals();
}

function updateTotals() {
  const subtotal = cart.reduce((sum, item) => sum + (item.price * item.qty), 0);
  const tax = subtotal * 0.18;
  const total = subtotal + tax;
  document.getElementById('subtotal').textContent = formatMoney(subtotal);
  document.getElementById('tax').textContent = formatMoney(tax);
  document.getElementById('total').textContent = formatMoney(total);
}

function addToCart(id, name, price, stock) {
  const existing = cart.find(item => item.id === id);
  if (existing) {
    if (existing.qty >= stock) {
      showAlert('Not enough stock available');
      return;
    }
    existing.qty++;
  } else {
    cart.push({ id, name, price: parseFloat(price), qty: 1 });
  }
  renderCart();
}

function changeQty(index, delta) {
  const item = cart[index];
  const product = products.find(p => p.id == item.id);
  const newQty = item.qty + delta;
  if (newQty <= 0) {
    cart.splice(index, 1);
  } else if (product && newQty > product.stock) {
    showAlert('Not enough stock available');
    return;
  } else {
    item.qty = newQty;
  }
  renderCart();
}

function removeItem(index) {
  cart.splice(index, 1);
  renderCart();
}

function clearCart() {
  cart = [];
  renderCart();
}

function openCheckout() {
  const total = cart.reduce((sum, item) => sum + (item.price * item.qty), 0) * 1.18;
  document.getElementById('amountPaid').value = total.toFixed(2);
  document.getElementById('modalAlert').style.display = 'none';
  document.getElementById('checkoutModal').classList.add('active');
}

function closeCheckout() {
  document.getElementById('checkoutModal').classList.remove('active');
}

function processCheckout() {
  const paymentMethod = document.getElementById('paymentMethod').value;
  const amountPaid = parseFloat(document.getElementById('amountPaid').value);
  const customerName = document.getElementById('customerName').value;
  const customerPhone = document.getElementById('customerPhone').value;
  const notes = document.getElementById('notes').value;

  const subtotal = cart.reduce((sum, item) => sum + (item.price * item.qty), 0);
  const total = subtotal * 1.18;

  if (!amountPaid || amountPaid < total) {
    showModalAlert('Amount paid must be at least ' + formatMoney(total));
    return;
  }

  const items = cart.map(item => ({
    product_id: item.id,
    name: item.name,
    price: item.price,
    quantity: item.qty
  }));

  fetch('{{ route("pos.checkout") }}', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
    },
    body: JSON.stringify({
      items,
      payment_method: paymentMethod,
      amount_paid: amountPaid,
      customer_name: customerName,
      customer_phone: customerPhone,
      notes: notes
    })
  })
  .then(r => r.json())
  .then(data => {
    if (data.success) {
      window.location.href = data.redirect;
    } else {
      showModalAlert(data.error || 'Checkout failed');
    }
  })
  .catch(err => {
    showModalAlert('Network error. Please try again.');
  });
}

// Product click handlers
document.querySelectorAll('.product-card').forEach(card => {
  card.addEventListener('click', () => {
    const id = parseInt(card.dataset.id);
    const name = card.dataset.name;
    const price = card.dataset.price;
    const stock = parseInt(card.dataset.stock);
    if (stock > 0) {
      addToCart(id, name, price, stock);
    }
  });
});

// Search filter
document.getElementById('productSearch').addEventListener('input', function() {
  const term = this.value.toLowerCase();
  document.querySelectorAll('.product-card').forEach(card => {
    const name = card.dataset.name.toLowerCase();
    card.style.display = name.includes(term) ? '' : 'none';
  });
});

// Close modal on backdrop click
document.getElementById('checkoutModal').addEventListener('click', function(e) {
  if (e.target === this) closeCheckout();
});

// Keyboard shortcut
document.addEventListener('keydown', function(e) {
  if (e.key === 'Escape') closeCheckout();
});

/* ========== CALCULATOR ========== */
let calcCurrent = '0';
let calcPrev = null;
let calcOpPending = null;
let calcResetNext = false;

function toggleCalculator() {
  document.getElementById('calculatorPanel').classList.toggle('active');
}

function updateCalcDisplay() {
  document.getElementById('calcDisplay').textContent = calcCurrent;
}

function calcNum(n) {
  if (calcResetNext) {
    calcCurrent = n === '.' ? '0.' : n;
    calcResetNext = false;
  } else {
    if (n === '.' && calcCurrent.includes('.')) return;
    if (calcCurrent === '0' && n !== '.') {
      calcCurrent = n;
    } else {
      calcCurrent += n;
    }
  }
  updateCalcDisplay();
}

function calcClear() {
  calcCurrent = '0';
  calcPrev = null;
  calcOpPending = null;
  calcResetNext = false;
  updateCalcDisplay();
}

function calcBackspace() {
  if (calcResetNext) {
    calcClear();
    return;
  }
  if (calcCurrent.length > 1) {
    calcCurrent = calcCurrent.slice(0, -1);
  } else {
    calcCurrent = '0';
  }
  updateCalcDisplay();
}

function calcOp(op) {
  const currentVal = parseFloat(calcCurrent);
  if (calcPrev !== null && calcOpPending && !calcResetNext) {
    calcEquals();
  }
  calcPrev = parseFloat(document.getElementById('calcDisplay').textContent);
  calcOpPending = op;
  calcResetNext = true;
}

function calcEquals() {
  if (calcPrev === null || !calcOpPending) return;
  const currentVal = parseFloat(calcCurrent);
  let result = 0;
  switch (calcOpPending) {
    case '+': result = calcPrev + currentVal; break;
    case '-': result = calcPrev - currentVal; break;
    case '*': result = calcPrev * currentVal; break;
    case '/':
      if (currentVal === 0) {
        calcCurrent = 'Error';
        calcPrev = null;
        calcOpPending = null;
        calcResetNext = true;
        updateCalcDisplay();
        return;
      }
      result = calcPrev / currentVal;
      break;
  }
  const maxDecimals = 8;
  result = parseFloat(result.toFixed(maxDecimals));
  calcCurrent = String(result);
  calcPrev = null;
  calcOpPending = null;
  calcResetNext = true;
  updateCalcDisplay();
}

// Calculator keyboard support (only when no input is focused)
document.addEventListener('keydown', function(e) {
  if (document.activeElement && ['INPUT', 'SELECT', 'TEXTAREA'].includes(document.activeElement.tagName)) return;
  if (document.getElementById('checkoutModal').classList.contains('active')) return;
  if (document.getElementById('addProductModal').classList.contains('active')) return;

  const key = e.key;
  if (/[0-9]/.test(key)) { calcNum(key); e.preventDefault(); }
  else if (key === '.') { calcNum('.'); e.preventDefault(); }
  else if (key === '+' || key === '-' || key === '*' || key === '/') { calcOp(key); e.preventDefault(); }
  else if (key === 'Enter' || key === '=') { calcEquals(); e.preventDefault(); }
  else if (key === 'Backspace') { calcBackspace(); e.preventDefault(); }
  else if (key === 'Escape' || key === 'c' || key === 'C') { calcClear(); e.preventDefault(); }
});

/* ========== QUICK ADD PRODUCT ========== */
function openAddProductModal() {
  document.getElementById('addProductAlert').style.display = 'none';
  document.getElementById('newProductName').value = '';
  document.getElementById('newProductPrice').value = '';
  document.getElementById('newProductStock').value = '1';
  document.getElementById('newProductCategory').value = 'General';
  document.getElementById('addProductModal').classList.add('active');
  document.getElementById('newProductName').focus();
}

function closeAddProductModal() {
  document.getElementById('addProductModal').classList.remove('active');
}

function showAddProductAlert(msg) {
  const box = document.getElementById('addProductAlert');
  box.textContent = msg;
  box.style.display = 'block';
}

function submitQuickAddProduct() {
  const name = document.getElementById('newProductName').value.trim();
  const price = parseFloat(document.getElementById('newProductPrice').value);
  const stock = parseInt(document.getElementById('newProductStock').value);
  const category = document.getElementById('newProductCategory').value;

  if (!name) {
    showAddProductAlert('Product name is required');
    return;
  }
  if (isNaN(price) || price < 0) {
    showAddProductAlert('Valid price is required');
    return;
  }
  if (isNaN(stock) || stock < 0) {
    showAddProductAlert('Valid stock quantity is required');
    return;
  }

  fetch('{{ route("pos.quick-add-product") }}', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
    },
    body: JSON.stringify({
      name: name,
      price_sale: price,
      quantity: stock,
      category: category
    })
  })
  .then(r => r.json())
  .then(data => {
    if (data.success && data.product) {
      // Add to products array
      products.push(data.product);

      // Create and insert product card
      const card = document.createElement('div');
      card.className = 'product-card';
      card.dataset.id = data.product.id;
      card.dataset.name = data.product.name;
      card.dataset.price = data.product.price_sale;
      card.dataset.stock = data.product.stock;
      card.innerHTML = `
        <span class="stock-badge">${data.product.stock} in stock</span>
        <h4>${data.product.name}</h4>
        <div class="price">$${parseFloat(data.product.price_sale).toFixed(2)}</div>
        <div class="add-icon"><i class="fas fa-plus"></i></div>
      `;
      card.addEventListener('click', () => {
        addToCart(data.product.id, data.product.name, data.product.price_sale, data.product.stock);
      });

      const grid = document.getElementById('productsGrid');
      // Remove "no products" message if present
      const emptyMsg = grid.querySelector('[style*="grid-column:1/-1"]');
      if (emptyMsg) emptyMsg.remove();

      grid.insertBefore(card, grid.firstChild);

      closeAddProductModal();
      showAlert('Product added successfully!', 'success');
    } else {
      showAddProductAlert(data.error || 'Failed to add product');
    }
  })
  .catch(err => {
    showAddProductAlert('Network error. Please try again.');
  });
}

// Close add product modal on backdrop click
document.getElementById('addProductModal').addEventListener('click', function(e) {
  if (e.target === this) closeAddProductModal();
});

// Escape key closes add product modal
document.addEventListener('keydown', function(e) {
  if (e.key === 'Escape' && document.getElementById('addProductModal').classList.contains('active')) {
    closeAddProductModal();
  }
});
</script>

</body>
</html>

