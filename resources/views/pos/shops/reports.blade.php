<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Reports — {{ $shop->name }} — OWERU POS</title>
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
.page p { color: var(--slate); font-size: 14px; }

.filter-bar { display: flex; gap: 8px; margin: 24px 0; }
.filter-bar a { padding: 8px 16px; border-radius: 3px; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; transition: all 0.2s; }
.filter-bar a.active { background: var(--ink); color: var(--cream); }
.filter-bar a:not(.active) { background: var(--white); border: 1px solid var(--border); color: var(--ink-muted); }
.filter-bar a:not(.active):hover { border-color: var(--gold); color: var(--gold); }

.stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 16px; margin-bottom: 32px; }
.stat-card { background: var(--white); border: 1px solid var(--border); border-radius: 3px; padding: 24px; }
.stat-card__value { font-size: 24px; font-weight: 700; color: var(--ink); }
.stat-card__label { font-size: 11px; color: var(--slate); text-transform: uppercase; letter-spacing: 1px; margin-top: 4px; }

.table-wrap { background: var(--white); border: 1px solid var(--border); border-radius: 3px; overflow: hidden; margin-bottom: 24px; }
table { width: 100%; border-collapse: collapse; }
th { text-align: left; padding: 12px 16px; font-size: 10px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; color: var(--ink-muted); background: var(--paper); border-bottom: 1px solid var(--border); }
td { padding: 12px 16px; font-size: 13px; border-bottom: 1px solid var(--border); }
tr:last-child td { border-bottom: none; }
.price { font-weight: 700; color: var(--gold); }

.section-title { font-family: 'Cormorant Garamond', serif; font-size: 1.3rem; font-weight: 600; margin-bottom: 16px; }

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
      <a href="{{ route('pos.shops.dashboard', $shop) }}" class="back-link">&larr; {{ $shop->name }}</a>
    </div>
  </div>
</header>

<div class="container">
  <div class="page">
    <h1>Sales <em>Reports</em></h1>
    <p>Financial performance and insights for {{ $shop->name }}.</p>

    <div class="filter-bar">
      <a href="{{ route('pos.shops.reports', ['shop' => $shop, 'period' => 'today']) }}" class="{{ $report['period'] === 'today' ? 'active' : '' }}">Today</a>
      <a href="{{ route('pos.shops.reports', ['shop' => $shop, 'period' => 'week']) }}" class="{{ $report['period'] === 'week' ? 'active' : '' }}">This Week</a>
      <a href="{{ route('pos.shops.reports', ['shop' => $shop, 'period' => 'month']) }}" class="{{ $report['period'] === 'month' ? 'active' : '' }}">This Month</a>
      <a href="{{ route('pos.shops.reports', ['shop' => $shop, 'period' => 'year']) }}" class="{{ $report['period'] === 'year' ? 'active' : '' }}">This Year</a>
    </div>

    <div class="stats-grid">
      <div class="stat-card">
        <div class="stat-card__value">{{ $report['total_sales'] }}</div>
        <div class="stat-card__label">Total Sales</div>
      </div>
      <div class="stat-card">
        <div class="stat-card__value">${{ number_format($report['total_revenue'], 2) }}</div>
        <div class="stat-card__label">Total Revenue</div>
      </div>
      <div class="stat-card">
        <div class="stat-card__value">${{ number_format($report['avg_sale_value'], 2) }}</div>
        <div class="stat-card__label">Average Sale</div>
      </div>
      <div class="stat-card">
        <div class="stat-card__value">{{ $report['total_items_sold'] }}</div>
        <div class="stat-card__label">Items Sold</div>
      </div>
    </div>

    <div class="two-col">
      <div>
        <h2 class="section-title">Payment Methods</h2>
        <div class="table-wrap">
          <table>
            <thead><tr><th>Method</th><th>Count</th></tr></thead>
            <tbody>
              @forelse($report['payment_breakdown'] as $method => $count)
              <tr>
                <td>{{ ucfirst(str_replace('_', ' ', $method)) }}</td>
                <td class="price">{{ $count }}</td>
              </tr>
              @empty
              <tr><td colspan="2" style="text-align:center;color:var(--slate);">No data.</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>

      <div>
        <h2 class="section-title">Top Products</h2>
        <div class="table-wrap">
          <table>
            <thead><tr><th>Product</th><th>Qty</th><th>Revenue</th></tr></thead>
            <tbody>
              @forelse($report['top_products'] as $product)
              <tr>
                <td>{{ $product->product_name }}</td>
                <td>{{ $product->total_qty }}</td>
                <td class="price">${{ number_format($product->total_revenue, 2) }}</td>
              </tr>
              @empty
              <tr><td colspan="3" style="text-align:center;color:var(--slate);">No data.</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

</body>
</html>

