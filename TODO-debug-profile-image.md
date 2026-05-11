# Debug: profile picture updates but only icon is visible

## Current findings
- Avatar in `resources/views/profile/edit.blade.php` uses `Auth::user()->profile_image_url`.
- Image upload handled by `ProfileController@uploadImage`.
- `User` model accessor `getProfileImageUrlAttribute()` returns `asset('storage/' . $this->profile_image)`.

## Next checks
1. After upload, confirm the DB column `users.profile_image` is set to something like `profile_images/<filename>`.
2. Confirm the browser `<img src="...">` points to `/storage/profile_images/<filename>`.
3. Confirm `/storage/profile_images/<filename>` returns HTTP 200.
4. Ensure `php artisan storage:link` has been run.

## If still failing
- Add a temporary log entry in `uploadImage()` and verify the request validation + storage write.
- Add fallback handling in the Blade templates if `profile_image_url` is missing.

