# Fix Store Profile Update Not Working

## Steps:
- [ ] 1. Read resources/views/store/edit.blade.php to confirm form field names
- [x] 2. Fix StoreController.php::update() method - map form fields to model attributes
- [x] 3. Test Profile → Manage Store → Edit → Update (update works, fixed related show() error)
- [x] 4. Verify database update and success message (confirmed from error log - data updated)
- [x] 5. Complete task
