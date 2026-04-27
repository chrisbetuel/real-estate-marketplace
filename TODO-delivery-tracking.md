# Client Delivery Route Tracking Implementation

## Status: 🔄 In Progress

### Approved Plan:
- **routes/web.php**: Add GET `/shop/orders/{order}/track` → StoreFrontController@trackOrder
- **StoreFrontController.php**: Add `trackOrder(Order $order)` method
- **New view**: `resources/views/shop/order-track.blade.php` (Google Maps tracking)
- **resources/views/store-front/order-detail.blade.php**: Add track button if driver assigned & in_delivery
- **Test**: Create order w/driver, track location updates

### Steps:
- [x] Add route `/shop/order/{order}/track`
- [x] Add `trackOrder()` method to StoreFrontController
- [x] Create `resources/views/shop/order-track.blade.php` (Google Maps w/ driver tracking, route)
- [x] Create `resources/views/store-front/order-details.blade.php` (w/ track button)
- [x] Update `store-front/my-orders.blade.php` (add track buttons)

