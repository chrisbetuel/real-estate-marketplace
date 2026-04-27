# Fix Store Products Not Showing for Clients

## Status: 🔄 In Progress

## Steps:

### 1. [ ] Debug - Check Laravel Logs
- Execute: `tail -20 storage/logs/laravel.log | grep "Store Detail View"`
- Confirm products is_active/stock values when client visits store

### 2. [ ] Temporary Fix - Relax Product Filter
- Edit `app/Http/Controllers/StoreFrontController.php`
- Comment out `->where('stock', '>', 0)` temporarily
- Test client store view

### 3. [ ] Fix Product Creation Form
- Read & edit `resources/views/store/products-create.blade.php`
- Set default stock input value="10"
- Ensure is_active checkbox checked by default

### 4. [ ] Standardize Field Names
- Replace `is_available` → `is_active` in:
  * app/Http/Controllers/StoreController.php
  * app/Http/Controllers/ProductController.php
- Update any views using is_available

### 5. [ ] Model Improvements
- Add stock default=0 cast in Product.php
- Add scope for visible products

### 6. [ ] Test Complete Flow
- Store owner: create product with stock=5
- Client: login → visit store → see products
- Restore stock filter if needed

### 7. [ ] Cleanup
- php artisan optimize:clear
- Remove temp log/debug code if not needed

**Current step: 1. Debug logs**

