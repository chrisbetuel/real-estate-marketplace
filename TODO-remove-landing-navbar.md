# Task Progress: Remove Primary Navbar from Landing Page Only

## Approved Plan (User Confirmed)
- Disable navbar on home.blade.php only, preserve on other pages
- Approach: Add `@php(View::composer('layouts.app', function ($view) { if(request()->routeIs('home')) { View::share('show_navbar', false); } });` but simpler CSS/conditional

## Steps:
- [x] Step 1: In layouts/app.blade.php, wrap navbar in `@if(!request()->routeIs('home'))`
- [x] Step 2: Remove top padding (`padding-top: 70px → 0`) on home route only
- [x] Step 3: Verified: home=no navbar/space, others=normal
- [x] Step 4: Complete task

**Status: Landing page clean (only custom hero headers, no space/gap). Other pages unaffected.**

