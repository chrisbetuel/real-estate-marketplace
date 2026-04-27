<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sales History — OWERU POS</title>
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
.container { max-width: 1000px; margin: 0 auto; padding: 0 24px; }

/* Header */
.header { position: sticky; top: 0; z-index: 500; background: rgba(245,242,236,0.96); backdrop-filter: blur(20px); border-bottom: 1px solid var(--border); }
.header__row { display: flex; align-items: center; justify-content: space-between; height: 60px; }
.logo { display: flex; align-items: center; gap: 10px; }
.logo__mark { width: 32px; height: 32px; background: var(--ink); border-radius: 4px; display: flex; align-items: center; justify-content: center; }
.logo__name { font-family: var(--f-sans); font-size: 14px; font-weight: 800; letter-spacing: 2px; color: var(--ink); }
.back-link { font-size: 12px; font-weight: 600; letter-spacing: 0.8px; color: var(--ink-muted); text-transform: uppercase; transition: color 0.2s; }
.back-link:hover { color: var(--gold); }

/* Page */
.page { padding: 40px 0; }
.page__hd { display: flex; align-items: flex-end; justify-content: space-between; margin-bottom: 32px; flex-wrap: wrap; gap: 16px; }
.page__hd h1 { font-family: 'Cormorant Garamond', serif; font-size: 2rem; font-weight: 600; margin-bottom: 4px; }
.page__hd p { font-size: 14px; color: var(--slate); }

/* Table */
.table-wrap { background: var(--white); border: 1px solid var(--border); border-radius: 3px; overflow: hidden; }
table { width: 100%; border-collapse: collapse; }
th { text-align: left; padding: 14px 24px; font-size: 11px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; color: var(--slate); background: var(--paper); border-bottom: 1px solid var(--border); }
td { padding: 16px 24px; font-size: 13px; border-bottom: 1px solid var(--border); color: var(--ink-muted); vertical-align: top; }
tr:last-child td { border-bottom: none; }
tr { transition: background 0.15s; }
tr:hover { background: var(--cream); }
td strong { color: var(--ink); }
.badge { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 10px; font-weight: 700; letter-spacing: 0.5px; text-transform: uppercase; }
.badge-cash { background: #ECFDF5; color: #059669; }
.badge-card { background: #EFF6FF; color: #2563EB; }
.badge-mobile { background: #FFFBEB; color: #D97706; }
.badge-completed { background: #ECFDF5; color: #059669; }

/* Items sublist */
.item-list { margin-top: 6px; }
.item-list li { font-size: 11px; color: var(--slate); line-height: 1.6; }

/* Actions */
.btn-sm { display: inline-flex; align-items: center; gap: 6px; padding: 6px 14px; border-radius: 3px; font-size: 11px; font-weight: 700; letter-spacing: 0.5px; text-transform: uppercase; text-decoration: none; transition: all 0.2s; border: none; cursor: pointer; }
.btn-receipt { background: var(--ink); color: var(--white); }
.btn-receipt:hover { background: var(--gold); color: var(--ink); }

/* Pagination */
.pagination { display: flex; justify-content: center; gap: 6px; padding: 20px; }
.pagination a, .pagination span { padding: 8px 14px; border: 1px solid var(--border); border-radius: 3px; font-size: 13px; font-weight: 600; color: var(--ink-muted); text-decoration: none; transition: all 0.2s; }
.pagination a:hover { border-color: var(--gold); color: var(--gold); }
.pagination .active { background: var(--gold); border-color: var(--gold); color: var(--ink); }

.empty { text-align: center; padding: 60px 20px; color: var(--slate); font-size: 14px; }
.empty i { font-size: 40px; margin-bottom: 16px; display: block; color: var(--border); }
.empty h3 { font-family: 'Cormorant Garamond', serif; font-size: 1.3rem; font-weight: 600; color: var(--ink); margin-bottom: 6px; }
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
      <a href="{{ route('pos.single-shop') }}" class="back-link">← Dashboard</a>
    </div>
  </div>
</header>

<div class="container">
  <div class="page">
    <div class="page__hd">
      <div>
        <h1>Sales History</h1>
        <p>All your past transactions in one place.</p>
      </div>
      <a href="{{ route('pos.sale') }}" class="btn-sm btn-receipt"><i class="fas fa-plus"></i> New Sale</a>
    </div>

    <div class="table-wrap">
      @if($sales->count() > 0)
        <table>
          <thead>
            <tr>
              <th>Receipt #</th>
              <th>Date & Time</th>
              <th>Items</th>
              <th>Payment</th>
              <th>Status</th>
              <th>Total</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            @foreach($sales as $sale)
              <tr>
                <td><strong>{{ $sale->sale_number }}</strong></td>
                <td>{{ $sale->created_at->format('M d, Y') }}<br><small style="color:var(--slate);">{{ $sale->created_at->format('H:i') }}</small></td>
                <td>
                  <strong>{{ $sale->items->sum('quantity') }} items</strong>
                  <ul class="item-list">
                    @foreach($sale->items->take(2) as $item)
                      <li>{{ $item->quantity }}x {{ $item->product_name }}</li>
                    @endforeach
                    @if($sale->items->count() > 2)
                      <li>+{{ $sale->items->count() - 2 }} more</li>
                    @endif
                  </ul>
                </td>
                <td>
                  <span class="badge badge-{{ $sale->payment_method == 'cash' ? 'cash' : ($sale->payment_method == 'card' ? 'card' : 'mobile') }}">
                    {{ ucfirst(str_replace('_', ' ', $sale->payment_method)) }}
                  </span>
                </td>
                <td><span class="badge badge-completed">{{ ucfirst($sale->status) }}</span></td>
                <td><strong>${{ number_format($sale->total_amount, 2) }}</strong></td>
                <td>
                  <a href="{{ route('pos.receipt', $sale) }}" class="btn-sm btn-receipt"><i class="fas fa-receipt"></i> Receipt</a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>

        <div class="pagination">
          {{ $sales->links() }}
        </div>
      @else
        <div class="empty">
          <i class="fas fa-receipt"></i>
          <h3>No sales yet</h3>
          <p>Your transaction history will appear here once you make your first sale.</p>
        </div>
      @endif
    </div>
  </div>
</div>

</body>
</html>

