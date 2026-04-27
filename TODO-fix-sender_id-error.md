# TODO: Fix sender_id column error in messages

## Steps:
- [x] 1. Update app/Models/Message.php: Fix sender() relationship to use 'user_id'
- [x] 2. Update app/Http/Controllers/ProfessionalDashboardController.php: Replace sender_id with user_id in unreadCount query
- [x] 3. Update app/Events/NewMessage.php: Use user_id and user relation instead of sender_id/sender
- [ ] 4. Clear Laravel caches
- [ ] 5. Test: Visit professional dashboard - no error
- [x] 6. Mark complete

Current progress: Files updated
