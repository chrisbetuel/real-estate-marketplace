<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $shop->name }} — OWERU POS</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;0,700&family=Syne:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
:root {
  --ink: #0C0F14; --ink-soft: #1A1F2B; --ink-muted: #3D4455;
  --paper: #F5F2EC; --paper-2: #EDE9E0; --cream: #FAF8F4;
  --gold: #B8963E; --gold-lt: #D4AF5E; --gold-pale: #F2EAD6;
  --white: #FFFFFF; --slate: #6B7385; --border: rgba(12,15,20,0.1);
  --danger: #DC2626; --success: #059669;
  --f-sans: 'Syne', sans-serif;
  --ease: cubic-bezier(0.25, 0.46, 0.45, 0.94);
}
*, *::before, *::after { margin:0; padding:0; box-sizing:border-box; }
body { font-family: var(--f-sans); background: var(--cream); color: var(--ink); -webkit-font-smoothing: antialiased; }
a { text-decoration: none; color: inherit; }
.container { max-width: 1200px; margin: 0 auto; padding: 0 32px; }

.header { position: sticky; top: 0; z-index: 500; background: rgba(245,242,236,0.96); backdrop-filter: blur(20px); border-bottom: 1px solid var(--border); }
.header__row { display: flex; align-items: center; justify-content: space-between; height: 60px; }
.logo { display: flex; align-items: center; gap: 10px; }
.logo__mark { width: 32px; height: 32px; background: var(--ink); border-radius: 4px; display: flex; align-items: center; justify-content: center; }
.logo__name { font-size: 14px; font-weight: 800; letter-spacing: 2px; }
.back-link { font-size: 12px; font-weight: 600; letter-spacing: 0.8px; color: var(--ink-muted); text-transform: uppercase; }
.back-link:hover { color: var(--gold); }

.hero { background: var(--ink); padding: 40px 0; }
.hero h1 { font-family: 'Cormorant Garamond', serif; font-size: clamp(1.6rem, 3vw, 2.2rem); font-weight: 300; color: var(--white); }
.hero h1 em { font-style: italic; color: var(--gold-lt); }
.hero p { font-size: 14px; color: rgba(255,255,255,0.5); margin-top: 6px; }
.hero-actions { display: flex; gap: 10px; margin-top: 20px; }
.btn-sm { font-family: var(--f-sans); font-size: 11px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; padding: 8px 16px; border: none; border-radius: 2px; cursor: pointer; transition: all 0.25s var(--ease); }
.btn-sm--gold { background: var(--gold); color: var(--ink); }
.btn-sm--gold:hover { background: var(--gold-lt); }
.btn-sm--outline { background: transparent; border: 1.5px solid rgba(255,255,255,0.3); color: var(--white); }
.btn-sm--outline:hover { border-color: var(--gold); color: var(--gold); }

.stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 16px; padding: 32px 0 16px; }
.stat-card { background: var(--white); border: 1px solid var(--border); border-radius: 3px; padding: 20px; }
.stat-card__value { font-size: 22px; font-weight: 700; color: var(--ink); }
.stat-card__label { font-size: 11px; color: var(--slate); text-transform: uppercase; letter-spacing: 1px; margin-top: 4px; }
.stat-card--alert { border-left: 3px solid var(--danger); }
.stat-card--alert .stat-card__value { color: var(--danger); }

.section { padding: 24px 0; }
.section-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px; }
.section-title { font-family: 'Cormorant Garamond', serif; font-size: 1.3rem; font-weight: 600; }

.table-wrap { background: var(--white); border: 1px solid var(--border); border-radius: 3px; overflow: hidden; }
table { width: 100%; border-collapse: collapse; }
th { text-align: left; padding: 12px 16px; font-size: 10px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; color: var(--ink-muted); background: var(--paper); border-bottom: 1px solid var(--border); }
td { padding: 12px 16px; font-size: 13px; border-bottom: 1px solid var(--border); }
tr:last-child td { border-bottom: none; }
.price { font-weight: 700; color: var(--gold); }
.badge { font-size: 10px; font-weight: 700; padding: 3px 10px; border-radius: 20px; text-transform: uppercase; }
.badge--success { background: #ECFDF5; color: var(--success); }

.two-col { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; }

@media (max-width: 768px) {
  .two-col { grid-template-columns: 1fr; }
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
      <a href="{{ route('pos.multi-shop') }}" class="back-link">&larr; Multi-Shop</a>
    </div>
  </div>
</header>

<section class="hero">
  <div class="container">
    <h1>{{ $shop->name }} <em>Dashboard</em></h1>
    <p>{{ $shop->location ?? 'No location set' }} &bull; {{ $shop->staff_count }} staff</p>
    <div class="hero-actions">
      <a href="{{ route('pos.shops.sale', $shop) }}" class="btn-sm btn-sm--gold"><i class="fas fa-cash-register"></i> New Sale</a>
      <a href="{{ route('pos.shops.reports', $shop) }}" class="btn-sm btn-sm--outline"><i class="fas fa-chart-bar"></i> Reports</a>
      <a href="{{ route('pos.shops.staff', $shop) }}" class="btn-sm btn-sm--outline"><i class="fas fa-users"></i> Staff</a>
    </div>
  </div>
</section>

<div class="container">
  <div class="stats-grid">
    <div class="stat-card">
      <div class="stat-card__value">${{ number_format($stats['today_revenue'], 2) }}</div>
      <div class="stat-card__label">Today's Revenue</div>
    </div>
    <div class="stat-card">
      <div class="stat-card__value">{{ $stats['today_sales_count'] }}</div>
      <div class="stat-card__label">Sales Today</div>
    </div>
    <div class="stat-card">
      <div class="stat-card__value">${{ number_format($stats['week_revenue'], 2) }}</div>
      <div class="stat-card__label">This Week</div>
    </div>
    <div class="stat-card">
      <div class="stat-card__value">${{ number_format($stats['total_revenue'], 2) }}</div>
      <div class="stat-card__label">Total Revenue</div>
    </div>
    <div class="stat-card stat-card--alert">
      <div class="stat-card__value">{{ $stats['low_stock'] }}</div>
      <div class="stat-card__label">Low Stock Items</div>
    </div>
    <div class="stat-card">
      <div class="stat-card__value">{{ $stats['out_of_stock'] }}</div>
      <div class="stat-card__label">Out of Stock</div>
    </div>
  </div>

  <div class="two-col" style="padding: 24px 0 48px;">
    <div>
      <div class="section-header">
        <h2 class="section-title">Recent Sales</h2>
        <a href="{{ route('pos.history') }}" style="font-size:12px;color:var(--gold);font-weight:600;">View All</a>
      </div>
      <div class="table-wrap">
        <table>
          <thead>
            <tr><th>Sale #</th><th>Amount</th><th>Time</th></tr>
          </thead>
          <tbody>
            @forelse($recentSales as $sale)
            <tr>
              <td>{{ $sale->sale_number }}</td>
              <td class="price">${{ number_format($sale->total_amount, 2) }}</td>
              <td>{{ $sale->sale_date->diffForHumans() }}</td>
            </tr>
            @empty
            <tr><td colspan="3" style="text-align:center;color:var(--slate);">No sales yet.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    <div>
      <div class="section-header">
        <h2 class="section-title">Inventory</h2>
      </div>
      <div class="table-wrap">
        <table>
          <thead>
            <tr><th>Product</th><th>Stock</th><th>Status</th></tr>
          </thead>
          <tbody>
            @forelse($inventories as $inv)
            <tr>
              <td>{{ $inv->product->name }}</td>
              <td>{{ $inv->quantity }}</td>
              <td>
                @if($inv->is_out_of_stock)
                  <span class="badge" style="background:#FEF2F2;color:var(--danger);">Out</span>
                @elseif($inv->is_low_stock)
                  <span class="badge" style="background:#FFFBEB;color:#D97706;">Low</span>
                @else
                  <span class="badge badge--success">OK</span>
                @endif
              </td>
            </tr>
            @empty
            <tr><td colspan="3" style="text-align:center;color:var(--slate);">No inventory yet.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

</body>
</html>

