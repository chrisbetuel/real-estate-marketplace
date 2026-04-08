# Service Ecosystem Fix

**Status:** Not working - shows "Something went wrong" on tab click.

**Root cause:** AJAX /ecosystem/stage/{stage} failing (500? network?).

**Fix Plan:**
1. **Data check:** No ProfessionalProfile matching professions → create demo seeder.
2. **Model:** Add User rating/reviews_count accessors.
3. **Controller:** Wrap in try-catch, always JSON.
4. **JS:** Add console.log(response.status).
5. **Caches:** Clear all.

**Implementation Steps:**
1. Create database/seeders/ProfessionalDemoSeeder.php
2. Run `php artisan db:seed --class=ProfessionalDemoSeeder`
3. Edit app/Models/User.php add:
   ```
   public function getRatingAttribute() {
       return $this->reviews()->avg('rating') ?? 4.8;
   }
   public function getReviewsCountAttribute() {
       return $this->reviews()->count() ?? 0;
   }
   ```
4. Edit ServiceEcosystemController add try-catch.
5. Test.

**Test Command:** `php artisan serve` then localhost:8000 click tab.

