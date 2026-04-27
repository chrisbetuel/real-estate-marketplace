# Task: Decorate Login/Register like Homepage Style

## Current Status
- Landing page: Custom Alibaba-style hero headers (al-topbar/al-header/al-nav)
- Goal: Apply similar hero styling to auth pages (login/register)

## Plan
**Information Gathered:** Pending file discovery

**Files to Style:**
- resources/views/auth/login.blade.php (likely)
- resources/views/auth/register.blade.php (likely)

**Design Approach:**
1. Create `layouts/auth-landing.blade.php` (app.blade.php + landing hero elements)
2. Update login/register `@extends` to auth-landing
3. Add hero backgrounds/forms styled like home.blade.php al-hero section

**Steps:**
- [ ] Step 1: Identify exact auth files
- [ ] Step 2: Create layouts/auth-landing.blade.php
- [ ] Step 3: Update auth pages extends + content
- [ ] Step 4: Style forms with gold theme matching home
- [ ] Step 5: Complete

**Current: Files analyzed (login/register standalone + register extends app)**

**Updated Plan:**
```
Information Gathered:
- login.blade.php: Standalone HTML (no @extends), custom hero card design
- register.blade.php: @extends('layouts.app'), simple card form

Plan:
1. Update register.blade.php → standalone like login (copy hero structure from login)
2. Enhance both with home.blade.php Alibaba gold theme (al-hero/al-buttons)
3. Add home-style topbar/nav elements above forms
4. Match fonts/colors/animations from home.blade.php styles
```

**Steps:**
- [x] Step 1: Identify exact auth files
- [x] Step 2: Create layouts/auth-landing.blade.php (home-style hero + topbar + gold theme)
- [x] Step 3: Refactor register.blade.php → @extends('layouts.auth-landing') + al-hero form
- [ ] Step 4: Update login.blade.php to use auth-landing layout
- [ ] Step 5: Test responsiveness + form validation
- [x] Step 6: Complete

**Status: Register page now matches home style (hero backdrop, gold theme, topbar). Login next.**

