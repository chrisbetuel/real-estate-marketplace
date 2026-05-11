<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Daily Report — OWERU POS</title>
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
.container { max-width: 900px; margin: 0 auto; padding: 0 24px; }

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
.page__hd { margin-bottom: 32px; }
.page__hd h1 { font-family: 'Cormorant Garamond', serif; font-size: 2rem; font-weight: 600; margin-bottom: 8px; }
.page__hd p { font-size: 14px; color: var(--slate); }

/* Date picker */
.date-bar { display: flex; align-items: center; gap: 12px; margin-bottom: 32px; }
.date-bar input { padding: 10px 14px; border: 1px solid var(--border); border-radius: 3px; font-family: var(--f-sans); font-size: 14px; outline: none; }
.date-bar input:focus { border-color: var(--gold); }
.date-bar button { padding: 10px 18px; background: var(--ink); color: var(--white); border: none; border-radius: 3px; font-family: var(--f-sans); font-size: 12px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; cursor: pointer; transition: all 0.2s; }
.date-bar button:hover { background: var(--gold); color: var(--ink); }

/* Stats grid */
.stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 16px; margin-bottom: 40px; }
.stat-card { background: var(--white); border: 1px solid var(--border); border-radius: 3px; padding: 24px; text-align: center; transition: all 0.2s; }
.stat-card:hover { box-shadow: 0 8px 24px rgba(12,15,20,0.06); transform: translateY(-2px); }
.stat-card__icon { width: 44px; height: 44px; background: var(--gold-pale); border-radius: 2px; display: inline-flex; align-items: center; justify-content: center; color: var(--gold); font-size: 18px; margin-bottom: 14px; }
.stat-card__val { font-size: 1.5rem; font-weight: 700; color: var(--ink); display: block; margin-bottom: 4px; }
.stat-card__lbl { font-size: 11px; font-weight: 600; letter-spacing: 1px; text-transform: uppercase; color: var(--slate); }
.stat-card--profit { border-color: var(--gold); }
.stat-card--profit .stat-card__icon { background: var(--gold); color: var(--ink); }
.stat-card--expense { border-color: #FEF2F2; }
.stat-card--expense .stat-card__icon { background: #FEF2F2; color: #DC2626; }

/* Table */
.table-wrap { background: var(--white); border: 1px solid var(--border); border-radius: 3px; overflow: hidden; margin-bottom: 32px; }
.table-wrap h3 { padding: 20px 24px; font-size: 14px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; border-bottom: 1px solid var(--border); }
table { width: 100%; border-collapse: collapse; }
th { text-align: left; padding: 12px 24px; font-size: 11px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; color: var(--slate); background: var(--paper); border-bottom: 1px solid var(--border); }
td { padding: 14px 24px; font-size: 13px; border-bottom: 1px solid var(--border); color: var(--ink-muted); }
tr:last-child td { border-bottom: none; }
td strong { color: var(--ink); }
.empty { text-align: center; padding: 48px; color: var(--slate); font-size: 14px; }
.empty i { font-size: 32px; margin-bottom: 12px; display: block; color: var(--border); }
.badge { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 10px; font-weight: 700; letter-spacing: 0.5px; text-transform: uppercase; }
.badge-cash { background: #ECFDF5; color: #059669; }
.badge-card { background: #EFF6FF; color: #2563EB; }
.badge-mobile { background: #FFFBEB; color: #D97706; }

/* Payment breakdown */
.breakdown { display: flex; gap: 12px; flex-wrap: wrap; margin-bottom: 32px; }
.breakdown-item { background: var(--white); border: 1px solid var(--border); border-radius: 3px; padding: 14px 20px; display: flex; align-items: center; gap: 10px; }
.breakdown-item i { color: var(--gold); }
.breakdown-item span { font-size: 13px; font-weight: 600; }
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
      <h1>Daily Sales Report</h1>
      <p>Review your sales and expense performance for a specific day.</p>
    </div>

    <form method="GET" action="{{ route('pos.daily-report') }}" class="date-bar">
      <input type="date" name="date" value="{{ $report['date'] }}">
      <button type="submit">Load Report</button>
    </form>

    <div class="stats-grid">
      <div class="stat-card">
        <div class="stat-card__icon"><i class="fas fa-receipt"></i></div>
        <span class="stat-card__val">{{ $report['total_sales'] }}</span>
        <span class="stat-card__lbl">Transactions</span>
      </div>
      <div class="stat-card">
        <div class="stat-card__icon"><i class="fas fa-dollar-sign"></i></div>
        <span class="stat-card__val">${{ number_format($report['total_revenue'], 2) }}</span>
        <span class="stat-card__lbl">Total Revenue</span>
      </div>
      <div class="stat-card stat-card--expense">
        <div class="stat-card__icon"><i class="fas fa-file-invoice-dollar"></i></div>
        <span class="stat-card__val">${{ number_format($report['total_expenses'], 2) }}</span>
        <span class="stat-card__lbl">Expenses</span>
      </div>
      <div class="stat-card stat-card--profit">
        <div class="stat-card__icon"><i class="fas fa-chart-line"></i></div>
        <span class="stat-card__val">${{ number_format($report['net_profit'], 2) }}</span>
        <span class="stat-card__lbl">Net Profit</span>
      </div>
      <div class="stat-card">
        <div class="stat-card__icon"><i class="fas fa-percentage"></i></div>
        <span class="stat-card__val">${{ number_format($report['total_tax'], 2) }}</span>
        <span class="stat-card__lbl">Tax Collected</span>
      </div>
      <div class="stat-card">
        <div class="stat-card__icon"><i class="fas fa-box"></i></div>
        <span class="stat-card__val">{{ $report['total_items_sold'] }}</span>
        <span class="stat-card__lbl">Items Sold</span>
      </div>
    </div>

    @if(count($report['payment_breakdown']) > 0)
      <div class="breakdown">
        @foreach($report['payment_breakdown'] as $method => $count)
          <div class="breakdown-item">
            <i class="fas fa-{{ $method == 'cash' ? 'money-bill-wave' : ($method == 'card' ? 'credit-card' : 'mobile-alt') }}"></i>
            <span>{{ ucfirst(str_replace('_', ' ', $method)) }}: {{ $count }} sale{{ $count > 1 ? 's' : '' }}</span>
          </div>
        @endforeach
      </div>
    @endif

    <div class="table-wrap">
      <h3>Transaction Details</h3>
      @if($report['sales']->count() > 0)
        <table>
          <thead>
            <tr>
              <th>Receipt #</th>
              <th>Time</th>
              <th>Items</th>
              <th>Payment</th>
              <th>Total</th>
            </tr>
          </thead>
          <tbody>
            @foreach($report['sales'] as $sale)
              <tr>
                <td><strong>{{ $sale->sale_number }}</strong></td>
                <td>{{ $sale->created_at->format('H:i') }}</td>
                <td>{{ $sale->items->sum('quantity') }}</td>
                <td>
                  <span class="badge badge-{{ $sale->payment_method == 'cash' ? 'cash' : ($sale->payment_method == 'card' ? 'card' : 'mobile') }}">
                    {{ ucfirst(str_replace('_', ' ', $sale->payment_method)) }}
                  </span>
                </td>
                <td><strong>${{ number_format($sale->total_amount, 2) }}</strong></td>
              </tr>
            @endforeach
          </tbody>
        </table>
      @else
        <div class="empty">
          <i class="fas fa-chart-line"></i>
          <p>No sales recorded for this day.</p>
        </div>
      @endif
    </div>

    @if(count($report['expense_breakdown']) > 0 || $report['expenses']->count() > 0)
      <div class="breakdown">
        @foreach($report['expense_breakdown'] as $category => $amount)
          <div class="breakdown-item">
            <i class="fas fa-tag"></i>
            <span>{{ $category }}: ${{ number_format($amount, 2) }}</span>
          </div>
        @endforeach
      </div>

      <div class="table-wrap">
        <h3>Expense Details</h3>
        @if($report['expenses']->count() > 0)
          <table>
            <thead>
              <tr>
                <th>Expense #</th>
                <th>Category</th>
                <th>Description</th>
                <th>Amount</th>
              </tr>
            </thead>
            <tbody>
              @foreach($report['expenses'] as $expense)
                <tr>
                  <td><strong>{{ $expense->expense_number }}</strong></td>
                  <td>{{ $expense->category }}</td>
                  <td>{{ $expense->description }}</td>
                  <td><strong>${{ number_format($expense->amount, 2) }}</strong></td>
                </tr>
              @endforeach
            </tbody>
          </table>
        @else
          <div class="empty">
            <i class="fas fa-file-invoice-dollar"></i>
            <p>No expenses recorded for this day.</p>
          </div>
        @endif
      </div>
    @endif
  </div>
</div>

</body>
</html>

