<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>New Sale — {{ $shop->name }} — OWERU POS</title>
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
body { font-family: var(--f-sans); background: var(--cream); color: var(--ink); -webkit-font-smoothing: antialiased; }
a { text-decoration: none; color: inherit; }
.container { max-width: 1400px; margin: 0 auto; padding: 0 24px; }

.header { position: sticky; top: 0; z-index: 500; background: rgba(245,242,236,0.96); backdrop-filter: blur(20px); border-bottom: 1px solid var(--border); }
.header__row { display: flex; align-items: center; justify-content: space-between; height: 60px; }
.logo { display: flex; align-items: center; gap: 10px; }
.logo__mark { width: 32px; height: 32px; background: var(--ink); border-radius: 4px; display: flex; align-items: center; justify-content: center; }
.logo__name { font-size: 14px; font-weight: 800; letter-spacing: 2px; }
.back-link { font-size: 12px; font-weight: 600; letter-spacing: 0.8px; color: var(--ink-muted); text-transform: uppercase; }
.back-link:hover { color: var(--gold); }

.pos-layout { display: grid; grid-template-columns: 1fr 380px; gap: 24px; padding: 24px 0; min-height: calc(100vh - 60px); }

.product-area { background: var(--white); border: 1px solid var(--border); border-radius: 3px; padding: 24px; }
.search-bar { display: flex; align-items: center; gap: 10px; background: var(--paper); border: 1px solid var(--border); border-radius: 3px; padding: 0 14px; margin-bottom: 20px; }
.search-bar input { flex: 1; border: none; background: transparent; padding: 12px 0; font-size: 14px; font-family: var(--f-sans); outline: none; }
.search-bar i { color: var(--slate); }
.btn-add-product { display: inline-flex; align-items: center; gap: 6px; padding: 8px 14px; background: var(--ink); color: var(--white); border: none; border-radius: 3px; font-family: var(--f-sans); font-size: 12px; font-weight: 700; letter-spacing: 0.5px; text-transform: uppercase; cursor: pointer; transition: all 0.2s; white-space: nowrap; }
.btn-add-product:hover { background: var(--gold); color: var(--ink); }
.products-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 16px; max-height: calc(100vh - 200px); overflow-y: auto; padding-right: 4px; }
.product-card { background: var(--cream); border: 1px solid var(--border); border-radius: 3px; padding: 16px; cursor: pointer; transition: all 0.2s; text-align: center; position: relative; }
.product-card:hover { border-color: var(--gold); transform: translateY(-2px); box-shadow: 0 8px 24px rgba(12,15,20,0.06); }
.product-card.out-of-stock { opacity: 0.5; pointer-events: none; }
.product-card .stock-badge { position: absolute; top: 8px; right: 8px; font-size: 10px; font-weight: 700; background: var(--gold-pale); color: var(--gold); padding: 2px 8px; border-radius: 20px; }
.product-card h4 { font-size: 13px; font-weight: 600; color: var(--ink); margin-bottom: 6px; line-height: 1.3; }
.product-card .price { font-size: 15px; font-weight: 700; color: var(--gold); }
.product-card .add-icon { width: 32px; height: 32px; background: var(--ink); color: var(--white); border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; margin-top: 10px; font-size: 12px; transition: all 0.2s; }
.product-card:hover .add-icon { background: var(--gold); color: var(--ink); }

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

.cart-footer { padding: 20px; border-top: 1px solid var(--border); background: var(--paper); }
.totals { margin-bottom: 16px; }
.total-row { display: flex; justify-content: space-between; font-size: 13px; margin-bottom: 8px; color: var(--ink-muted); }
.total-row.grand { font-size: 16px; font-weight: 700; color: var(--ink); padding-top: 8px; border-top: 1px solid var(--border); }
.btn-checkout { width: 100%; padding: 14px; background: var(--gold); color: var(--ink); border: none; border-radius: 3px; font-family: var(--f-sans); font-size: 12px; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; cursor: pointer; transition: all 0.25s; }
.btn-checkout:hover { background: var(--gold-lt); transform: translateY(-1px); box-shadow: 0 8px 24px rgba(184,150,62,0.35); }
.btn-checkout:disabled { background: var(--border); color: var(--slate); cursor: not-allowed; transform: none; box-shadow: none; }

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
        <a href="{{ route('pos.shops.dashboard', $shop) }}" class="back-link">&larr; {{ $shop->name }}</a>
      </div>
    </div>
  </div>
</header>

<div class="container">
  <div class="pos-layout">
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
          <div class="product-card {{ $product['stock'] <= 0 ? 'out-of-stock' : '' }}" 
               data-id="{{ $product['id'] }}" 
               data-name="{{ $product['name'] }}" 
               data-price="{{ $product['price_sale'] }}"
               data-stock="{{ $product['stock'] }}">
            @if($product['stock'] > 0)
              <span class="stock-badge">{{ $product['stock'] }} in stock</span>
            @else
              <span class="stock-badge" style="background:#FEF2F2;color:#DC2626;">Out of stock</span>
            @endif
            <h4>{{ $product['name'] }}</h4>
            <div class="price">${{ number_format($product['price_sale'], 2) }}</div>
            @if($product['stock'] > 0)
              <div class="add-icon"><i class="fas fa-plus"></i></div>
            @endif
          </div>
        @empty
          <div style="grid-column:1/-1;text-align:center;padding:40px;color:var(--slate);font-size:14px;">
            <i class="fas fa-box-open" style="font-size:32px;margin-bottom:12px;display:block;color:var(--border);"></i>
            No products in this shop's inventory.
          </div>
        @endforelse
      </div>
    </div>

    <div class="cart-area">
      <div class="cart-header">
        <h3><i class="fas fa-shopping-cart" style="margin-right:8px;color:var(--gold);"></i>Current Sale</h3>
        <span class="clear" onclick="clearCart()"><i class="fas fa-trash-alt"></i> Clear</span>
      </div>
      <div class="cart-items" id="cartItems">
        <div class="empty-cart">
          <i class="fas fa-shopping-basket"></i>
          <p>Tap a product to add it to the cart</p>
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
        <option value="mpesa">M-Pesa</option>
        <option value="airtel_money">Airtel Money</option>
        <option value="halopesa">HaloPesa</option>
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
const shopId = {{ $shop->id }};
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
  const total = subtotal
