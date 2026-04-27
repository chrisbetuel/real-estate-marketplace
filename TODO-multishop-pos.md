# Multi-Shop POS Implementation TODO

## Step 1: Migrations
- [x] Create `pos_shops` table
- [x] Create `pos_shop_user` pivot table (roles: admin/manager/cashier)
- [x] Create `pos_inventories` table (shop-specific stock)
- [x] Create `pos_stock_transfers` table
- [x] Add `pos_shop_id` to `pos_sales` table

## Step 2: Models
- [x] `app/Models/PosShop.php`
- [x] `app/Models/PosShopUser.php`
- [x] `app/Models/PosInventory.php`
- [x] `app/Models/PosStockTransfer.php`
- [x] Update `app/Models/PosSale.php` (add posShop relationship)
- [x] Update `app/Models/User.php` (add pos shop access methods)

## Step 3: Controller
- [x] Update `app/Http/Controllers/PosController.php` with all multi-shop methods

## Step 4: Routes
- [x] Update `routes/web.php` with new POS routes

## Step 5: Views
- [x] Redesign `resources/views/pos/multi-shop.blade.php`
- [x] Create `resources/views/pos/shops/create.blade.php`
- [x] Create `resources/views/pos/shops/index.blade.php`
- [x] Create `resources/views/pos/shops/dashboard.blade.php`
- [x] Create `resources/views/pos/shops/sale.blade.php`
- [x] Create `resources/views/pos/shops/reports.blade.php`
- [x] Create `resources/views/pos/shops/staff.blade.php`
- [x] Create `resources/views/pos/shops/transfer.blade.php`

## Step 6: Follow-up
- [ ] Run `php artisan migrate`
- [ ] Clear route cache
- [ ] Test routes


