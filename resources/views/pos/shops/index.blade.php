<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My Shops — OWERU POS</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;0,700&family=Syne:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
:root {
  --ink: #0C0F14; --ink-soft: #1A1F2B; --ink-muted: #3D4455;
  --paper: #F5F2EC; --paper-2: #EDE9E0; --cream: #FAF8F4;
  --gold: #B8963E; --gold-lt: #D4AF5E; --gold-pale: #F2EAD6;
  --white: #FFFFFF; --slate: #6B7385; --border: rgba(12,15,20,0.1);
  --f-sans: 'Syne', sans-serif;
  --ease: cubic-bezier(0.25, 0.46, 0.45, 0.94);
}
*, *::before, *::after { margin:0; padding:0; box-sizing:border-box; }
body { font-family: var(--f-sans); background: var(--cream); color: var(--ink); -webkit-font-smoothing: antialiased; }
a { text-decoration: none; color: inherit; }
.container { max-width: 1100px; margin: 0 auto; padding: 0 32px; }

.header { position: sticky; top: 0; z-index: 500; background: rgba(245,242,236,0.96); backdrop-filter: blur(20px); border-bottom: 1px solid var(--border); }
.header__row { display: flex; align-items: center; justify-content: space-between; height: 60px; }
.logo { display: flex; align-items: center; gap: 10px; }
.logo__mark { width: 32px; height: 32px; background: var(--ink); border-radius: 4px; display: flex; align-items: center; justify-content: center; }
.logo__name { font-size: 14px; font-weight: 800; letter-spacing: 2px; }
.back-link { font-size: 12px; font-weight: 600; letter-spacing: 0.8px; color: var(--ink-muted); text-transform: uppercase; }
.back-link:hover { color: var(--gold); }

.page { padding: 40px 0; }
.page h1 { font-family: 'Cormorant Garamond', serif; font-size: 2rem; font-weight: 300; margin-bottom: 8px; }
.page p { color: var(--slate); font-size: 14px; margin-bottom: 32px; }

.btn { display: inline-flex; align-items: center; gap: 8px; font-family: var(--f-sans); font-size: 11px; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; padding: 10px 20px; border: none; border-radius: 2px; cursor: pointer; transition: all 0.25s var(--ease); }
.btn--gold { background: var(--gold); color: var(--ink); }
.btn--gold:hover { background: var(--gold-lt); }
.btn--outline { background: transparent; border: 1.5px solid var(--ink); color: var(--ink); }
.btn--outline:hover { background: var(--ink); color: var(--cream); }

.shop-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 16px; }
.shop-card { background: var(--white); border: 1px solid var(--border); border-radius: 3px; padding: 24px; transition: all 0.3s var(--ease); }
.shop-card:hover { box-shadow: 0 12px 40px rgba(12,15,20,0.08); transform: translateY(-3px); border-color: var(--gold); }
.shop-card__header { display: flex; align-items: center; gap: 14px; margin-bottom: 16px; }
.shop-card__icon { width: 48px; height: 48px; background: var(--ink); border-radius: 3px; display: flex; align-items: center; justify-content: center; color: var(--gold); font-size: 20px; }
.shop-card__info h3 { font-size: 15px; font-weight: 700; margin-bottom: 4px; }
.shop-card__info span { font-size: 12px; color: var(--slate); }
.badge { font-size: 10px; font-weight: 700; padding: 3px 10px; border-radius: 20px; text-transform: uppercase; }
.badge--owner { background: var(--gold-pale); color: var(--gold); }
.badge--staff { background: #EFF6FF; color: #2563EB; }
.shop-card__actions { display: flex; gap: 8px; margin-top: 16px; }
.shop-card__actions a { flex: 1; text-align: center; padding: 8px; border-radius: 2px; font-size: 11px; font-weight: 700; letter-spacing: 0.8px; text-transform: uppercase; transition: all 0.2s; }
.btn-action { background: var(--gold-pale); color: var(--gold); }
.btn-action:hover { background: var(--gold); color: var(--ink); }
</style>
</head>
<body>

<header class="header">
  <div class="container">
    <div class="header__row">
      <a href="/" class="logo">
        <div class="logo__mark">
          <svg width="18" height="18" viewBox="0 0 20 20" fill="none"><path d="M3 15 L7 5 L10 10 L13 7 L17 15" stroke="#C9A84C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </div>
        <span class="logo__name">OWERU POS</span>
      </a>
      <a href="{{ route('pos.multi-shop') }}" class="back-link">&larr; Dashboard</a>
    </div>
  </div>
</header>

<div class="container">
  <div class="page">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;">
      <div>
        <h1>My <em>Shops</em></h1>
        <p>All shops you own or manage.</p>
      </div>
      <a href="{{ route('pos.shops.create') }}" class="btn btn--gold"><i class="fas fa-plus"></i> New Shop</a>
    </div>

    <div class="shop-grid">
      @forelse($shops as $shop)
      <div class="shop-card">
        <div class="shop-card__header">
          <div class="shop-card__icon"><i class="fas fa-store"></i></div>
          <div class="shop-card__info">
            <h3>{{ $shop->name }}</h3>
            <span>{{ $shop->location ?? 'No location' }}</span>
          </div>
        </div>
        <div style="display:flex;gap:8px;margin-bottom:12px;">
          @if($shop->owner_id === Auth::id())
            <span class="badge badge--owner">Owner</span>
          @else
            <span class="badge badge--staff">Staff</span>
          @endif
          @if($shop->is_active)
            <span class="badge" style="background:#ECFDF5;color:#059669;">Active</span>
          @else
            <span class="badge" style="background:#F3F4F6;color:var(--slate);">Inactive</span>
          @endif
        </div>
        <div class="shop-card__actions">
          <a href="{{ route('pos.shops.dashboard', $shop) }}" class="btn-action">Dashboard</a>
          <a href="{{ route('pos.shops.sale', $shop) }}" class="btn-action">Sell</a>
        </div>
      </div>
      @empty
      <div class="shop-card" style="text-align:center;padding:48px 24px;grid-column:1/-1;">
        <i class="fas fa-store-slash" style="font-size:32px;color:var(--slate);margin-bottom:16px;display:block;"></i>
        <h3 style="margin-bottom:8px;">No shops yet</h3>
        <p style="font-size:13px;color:var(--slate);margin-bottom:20px;">Create your first POS shop to get started.</p>
        <a href="{{ route('pos.shops.create') }}" class="btn btn--gold">Create Shop</a>
      </div>
      @endforelse
    </div>
  </div>
</div>

</body>
</html>

