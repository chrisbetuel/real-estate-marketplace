# POS System Implementation TODO

## Phase 1 — MVP: Single-Shop POS

### Step 1: Database Migrations
- [ ] Create `pos_sales` table
- [ ] Create `pos_sale_items` table  
- [ ] Create `pos_customers` table
- [ ] Add POS fields to `products` table (sku, barcode, cost_price, tax_rate, reorder_level)

### Step 2: Models
- [ ] Create `PosSale` model
- [ ] Create `PosSaleItem` model
- [ ] Create `PosCustomer` model
- [ ] Update `Product` model with new POS fields

### Step 3: Routes & Controller
- [ ] Register POS routes in `routes/web.php`
- [ ] Create `PosController` with: index, sale, checkout, receipt, dailyReport

### Step 4: Homepage Link
- [ ] Add "Point of Sale" link to `home.blade.php` header navigation

### Step 5: Views
- [ ] Create POS layout (`resources/views/pos/layout.blade.php`)
- [ ] Create POS dashboard/index view
- [ ] Create POS sales screen (cart, product search, checkout)
- [ ] Create POS receipt view (print-friendly)
- [ ] Create POS daily report view

### Step 6: Offline Support
- [ ] Create `public/js/pos-offline.js` for localStorage queueing

### Step 7: Testing & Migration
- [ ] Run `php artisan migrate`
- [ ] Test POS flow end-to-end

## Phase 2 — Multi-Shop POS (Future)
- [ ] Add shop_id to POS transactions
- [ ] Central stock visibility
- [ ] Stock transfers between shops
- [ ] Consolidated reporting
- [ ] Central customer loyalty

## Phase 3 — Polish (Future)
- [ ] User roles: cashier, manager, admin
- [ ] Email/SMS receipts
- [ ] Head office view
- [ ] Inter-shop returns

