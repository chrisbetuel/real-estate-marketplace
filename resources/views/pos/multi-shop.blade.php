<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Multi-Shop POS Dashboard — OWERU</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;0,700&family=Syne:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
:root {
  --ink: #0C0F14; --ink-soft: #1A1F2B; --ink-muted: #3D4455;
  --paper: #F5F2EC; --paper-2: #EDE9E0; --cream: #FAF8F4;
  --gold: #B8963E; --gold-lt: #D4AF5E; --gold-pale: #F2EAD6;
  --white: #FFFFFF; --slate: #6B7385; --border: rgba(12,15,20,0.1);
  --danger: #DC2626; --danger-bg: #FEF2F2;
  --success: #059669; --success-bg: #ECFDF5;
  --f-sans: 'Syne', sans-serif;
  --ease: cubic-bezier(0.25, 0.46, 0.45, 0.94);
}
*, *::before, *::after { margin:0; padding:0; box-sizing:border-box; }
body { font-family: var(--f-sans); background: var(--cream); color: var(--ink); -webkit-font-smoothing: antialiased; }
a { text-decoration: none; color: inherit; }
.container { max-width: 1200px; margin: 0 auto; padding: 0 32px; }

/* Header */
.header { position: sticky; top: 0; z-index: 500; background: rgba(245,242,236,0.96); backdrop-filter: blur(20px); border-bottom: 1px solid var(--border); }
.header__row { display: flex; align-items: center; justify-content: space-between; height: 60px; }
.logo { display: flex; align-items: center; gap: 10px; }
.logo__mark { width: 32px; height: 32px; background: var(--ink); border-radius: 4px; display: flex; align-items: center; justify-content: center; }
.logo__name { font-family: var(--f-sans); font-size: 14px; font-weight: 800; letter-spacing: 2px; color: var(--ink); }
.nav-links { display: flex; align-items: center; gap: 20px; }
.nav-link { font-size: 11.5px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; color: var(--ink-muted); padding: 8px 0; transition: color 0.2s; }
.nav-link:hover, .nav-link.active { color: var(--gold); }
.btn-sm { font-family: var(--f-sans); font-size: 11px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; padding: 8px 16px; border: none; border-radius: 2px; cursor: pointer; transition: all 0.25s var(--ease); }
.btn-sm--gold { background: var(--gold); color: var(--ink); }
.btn-sm--gold:hover { background: var(--gold-lt); }

/* Hero */
.hero { background: var(--ink); padding: 48px 0; position: relative; overflow: hidden; }
.hero::before { content: ''; position: absolute; inset: 0; background: radial-gradient(ellipse at 20% 50%, rgba(184,150,62,0.1) 0%, transparent 55%); }
.hero__inner { position: relative; z-index: 1; }
.hero h1 { font-family: 'Cormorant Garamond', serif; font-size: clamp(1.8rem, 3vw, 2.6rem); font-weight: 300; color: var(--white); margin-bottom: 8px; }
.hero h1 em { font-style: italic; color: var(--gold-lt); }
.hero p { font-size: 14px; color: rgba(255,255,255,0.5); max-width: 480px; }

/* Stats */
.stats { padding: 32px 0 16px; }
.stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 16px; }
.stat-card { background: var(--white); border: 1px solid var(--border); border-radius: 3px; padding: 24px; transition: all 0.3s var(--ease); }
.stat-card:hover { box-shadow: 0 8px 24px rgba(12,15,20,0.06); transform: translateY(-2px); }
.stat-card__top { display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px; }
.stat-card__icon { width: 40px; height: 40px; background: var(--gold-pale); border-radius: 3px; display: flex; align-items: center; justify-content: center; color: var(--gold); font-size: 16px; }
.stat-card__value { font-size: 24px; font-weight: 700; color: var(--ink); }
.stat-card__label { font-size: 12px; color: var(--slate); font-weight: 600; text-transform: uppercase; letter-spacing: 1px; }
.stat-card__change { font-size: 11px; color: var(--success); margin-top: 4px; }

/* Section */
.section { padding: 24px 0; }
.section-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; }
.section-title { font-family: 'Cormorant Garamond', serif; font-size: 1.4rem; font-weight: 600; color: var(--ink); }
.btn { display: inline-flex; align-items: center; gap: 8px; font-family: var(--f-sans); font-size: 11px; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; padding: 10px 20px; border: none; border-radius: 2px; cursor: pointer; transition: all 0.25s var(--ease); }
.btn--outline { background: transparent; border: 1.5px solid var(--ink); color: var(--ink); }
.btn--outline:hover { background: var(--ink); color: var(--cream); }
.btn--gold { background: var(--gold); color: var(--ink); }
.btn--gold:hover { background: var(--gold-lt); }

/* Shop cards */
.shop-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 16px; }
.shop-card { background: var(--white); border: 1px solid var(--border); border-radius: 3px; padding: 24px; transition: all 0.3s var(--ease); position: relative; }
.shop-card:hover { box-shadow: 0 12px 40px rgba(12,15,20,0.08); transform: translateY(-3px); border-color: var(--gold); }
.shop-card__header { display: flex; align-items: center; gap: 14px; margin-bottom: 16px; }
.shop-card__icon { width: 48px; height: 48px; background: var(--ink); border-radius: 3px; display: flex; align-items: center; justify-content: center; color: var(--gold); font-size: 20px; }
.shop-card__info h3 { font-size: 15px; font-weight: 700; margin-bottom: 4px; }
.shop-card__info span { font-size: 12px; color: var(--slate); }
.shop-card__stats { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; margin: 16px 0; padding: 16px 0; border-top: 1px solid var(--border); border-bottom: 1px solid var(--border); }
.shop-card__stat { text-align: center; }
.shop-card__stat-value { font-size: 18px; font-weight: 700; color: var(--ink); }
.shop-card__stat-label { font-size: 10px; color: var(--slate); text-transform: uppercase; letter-spacing: 1px; margin-top: 4px; }
.shop-card__actions { display: flex; gap: 8px; }
.shop-card__actions a { flex: 1; text-align: center; padding: 8px; border-radius: 2px; font-size: 11px; font-weight: 700; letter-spacing: 0.8px; text-transform: uppercase; transition: all 0.2s; }
.btn-action { background: var(--gold-pale); color: var(--gold); }
.btn-action:hover { background: var(--gold); color: var(--ink); }

/* Table */
.table-wrap { background: var(--white); border: 1px solid var(--border); border-radius: 3px; overflow: hidden; }
table { width: 100%; border-collapse: collapse; }
th { text-align: left; padding: 12px 16px; font-size: 10px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; color: var(--ink-muted); background: var(--paper); border-bottom: 1px solid var(--border); }
td { padding: 12px 16px; font-size: 13px; border-bottom: 1px solid var(--border); }
tr:last-child td { border-bottom: none; }
.badge { display: inline-flex; align-items: center; gap: 6px; font-size: 10px; font-weight: 700; padding: 3px 10px; border-radius: 20px; text-transform: uppercase; }
.badge--gold { background: var(--gold-pale); color: var(--gold); }
.badge--danger { background: var(--danger-bg); color: var(--danger); }
.badge--success { background: var(--success-bg); color: var(--success); }
.price { font-weight: 700; color: var(--gold); }

/* Alerts panel */
.alert-item { display: flex; align-items: center; gap: 12px; padding: 10px 16px; border-left: 3px solid var(--danger); background: var(--danger-bg); margin-bottom: 8px; border-radius: 0 3px 3px 0; }
.alert-item span { font-size: 12px; color: var(--danger); }
.alert-item strong { color: var(--ink); }

/* Two column */
.two-col { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; }

@media (max-width: 768px) {
  .two-col { grid-template-columns: 1fr; }
  .shop-grid { grid-template-columns: 1fr; }
  .stats-grid { grid-template-columns: repeat(2, 1fr); }
}
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
      <div class="nav-links">
        <a href="{{ route('pos.single-shop') }}" class="nav-link">Single Shop</a>
        <a href="{{ route('pos.multi-shop') }}" class="nav-link active">Multi-Shop</a>
        <a href="{{ route('pos.sale') }}" class="nav-link">New Sale</a>
        <a href="{{ route('pos.shops.create') }}" class="btn-sm btn-sm--gold"><i class="fas fa-plus"></i> Add Shop</a>
      </div>
    </div>
  </div>
</header>

<section class="hero">
  <div class="container">
    <div class="hero__inner">
      <h1>Multi-Shop <em>Dashboard</em></h1>
      <p>Centralized control for all your store locations. Track sales, manage inventory, and monitor performance across every shop.</p>
    </div>
  </div>
</section>

<div class="container">
  <div class="stats">
    <div class="stats-grid">
      <div class="stat-card">
        <div class="stat-card__top">
          <div class="stat-card__icon"><i class="fas fa-store"></i></div>
        </div>
        <div class="stat-card__value">{{ $stats['total_shops'] }}</div>
        <div class="stat-card__label">Total Shops</div>
      </div>
      <div class="stat-card">
        <div class="stat-card__top">
          <div class="stat-card__icon"><i class="fas fa-money-bill-wave"></i></div>
        </div>
        <div class="stat-card__value">${{ number_format($stats['total_revenue'], 2) }}</div>
        <div class="stat-card__label">Total Revenue</div>
      </div>
      <div class="stat-card">
        <div class="stat-card__top">
          <div class="stat-card__icon"><i class="fas fa-calendar-day"></i></div>
        </div>
        <div class="stat-card__value">${{ number_format($stats['today_revenue'], 2) }}</div>
        <div class="stat-card__label">Today's Sales</div>
        <div class="stat-card__change">{{ $stats['today_sales_count'] }} transactions</div>
      </div>
      <div class="stat-card">
        <div class="stat-card__top">
          <div class="stat-card__icon"><i class="fas fa-boxes"></i></div>
        </div>
        <div class="stat-card__value">{{ $stats['total_items_sold'] }}</div>
        <div class="stat-card__label">Items Sold</div>
      </div>
    </div>
  </div>

  @if($bestShop)
  <div class="section" style="padding: 8px 0 24px;">
    <div class="stat-card" style="display:flex;align-items:center;gap:16px;padding:16px 24px;">
      <div class="stat-card__icon"><i class="fas fa-trophy"></i></div>
      <div>
        <div style="font-size:12px;color:var(--slate);text-transform:uppercase;letter-spacing:1px;">Best Performing Shop</div>
        <div style="font-size:18px;font-weight:700;">{{ $bestShop->name }}</div>
        <div style="font-size:13px;color:var(--gold);">${{ number_format($bestShop->total_revenue, 2) }} total revenue</div>
      </div>
    </div>
  </div>
  @endif

  <div class="section">
    <div class="section-header">
      <h2 class="section-title">Your Shops</h2>
      <a href="{{ route('pos.shops.create') }}" class="btn btn--gold"><i class="fas fa-plus"></i> New Shop</a>
    </div>
    <div class="shop-grid">
      @forelse($shops as $shop)
      <div class="shop-card">
        <div class="shop-card__header">
          <div class="shop-card__icon"><i class="fas fa-store"></i></div>
          <div class="shop-card__info">
            <h3>{{ $shop->name }}</h3>
            <span>{{ $shop->location ?? 'No location set' }}</span>
          </div>
        </div>
        <div class="shop-card__stats">
          <div class="shop-card__stat">
            <div class="shop-card__stat-value">${{ number_format($shop->today_revenue, 2) }}</div>
            <div class="shop-card__stat-label">Today</div>
          </div>
          <div class="shop-card__stat">
            <div class="shop-card__stat-value">{{ $shop->today_sales_count }}</div>
            <div class="shop-card__stat-label">Sales</div>
          </div>
          <div class="shop-card__stat">
            <div class="shop-card__stat-value">{{ $shop->staff_count }}</div>
            <div class="shop-card__stat-label">Staff</div>
          </div>
        </div>
        <div class="shop-card__actions">
          <a href="{{ route('pos.shops.dashboard', $shop) }}" class="btn-action">Dashboard</a>
          <a href="{{ route('pos.shops.sale', $shop) }}" class="btn-action">Sell</a>
          <a href="{{ route('pos.shops.reports', $shop) }}" class="btn-action">Reports</a>
        </div>
      </div>
      @empty
      <div class="shop-card" style="text-align:center;padding:48px 24px;">
        <i class="fas fa-store-slash" style="font-size:32px;color:var(--slate);margin-bottom:16px;display:block;"></i>
        <h3 style="margin-bottom:8px;">No shops yet</h3>
        <p style="font-size:13px;color:var(--slate);margin-bottom:20px;">Create your first POS shop to get started.</p>
        <a href="{{ route('pos.shops.create') }}" class="btn btn--gold">Create Shop</a>
      </div>
      @endforelse
    </div>
  </div>

  <div class="two-col" style="padding: 24px 0 48px;">
    <div>
      <div class="section-header">
        <h2 class="section-title">Low Stock Alerts</h2>
      </div>
      @if($lowStockAlerts->count())
        @foreach($lowStockAlerts as $alert)
        <div class="alert-item">
          <i class="fas fa-exclamation-triangle"></i>
          <span><strong>{{ $alert->product->name }}</strong> in {{ $alert->shop->name }} — Only {{ $alert->quantity }} left</span>
        </div>
        @endforeach
      @else
        <div class="table-wrap" style="padding:24px;text-align:center;color:var(--slate);font-size:13px;">
          <i class="fas fa-check-circle" style="color:var(--success);margin-bottom:8px;display:block;font-size:24px;"></i>
          All stock levels are healthy.
        </div>
      @endif
    </div>

    <div>
      <div class="section-header">
        <h2 class="section-title">Recent Sales</h2>
        <a href="{{ route('pos.history') }}" class="btn btn--outline">View All</a>
      </div>
      <div class="table-wrap">
        <table>
          <thead>
            <tr><th>Sale #</th><th>Shop</th><th>Amount</th><th>Status</th></tr>
          </thead>
          <tbody>
            @forelse($recentSales as $sale)
            <tr>
              <td><strong>{{ $sale->sale_number }}</strong></td>
              <td>{{ $sale->posShop->name ?? 'N/A' }}</td>
              <td class="price">${{ number_format($sale->total_amount, 2) }}</td>
              <td><span class="badge badge--success">{{ ucfirst($sale->status) }}</span></td>
            </tr>
            @empty
            <tr><td colspan="4" style="text-align:center;color:var(--slate);">No recent sales.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

</body>
</html>

