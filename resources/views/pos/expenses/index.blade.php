<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Expenses — OWERU POS</title>
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

/* Stats */
.stats-bar { display: flex; gap: 16px; margin-bottom: 32px; flex-wrap: wrap; }
.stat-pill { background: var(--white); border: 1px solid var(--border); border-radius: 3px; padding: 16px 24px; min-width: 160px; }
.stat-pill__val { font-size: 1.3rem; font-weight: 700; color: var(--ink); display: block; }
.stat-pill__lbl { font-size: 11px; font-weight: 600; letter-spacing: 1px; text-transform: uppercase; color: var(--slate); }

/* Filters */
.filter-bar { display: flex; align-items: center; gap: 12px; margin-bottom: 24px; flex-wrap: wrap; }
.filter-bar input, .filter-bar select { padding: 10px 14px; border: 1px solid var(--border); border-radius: 3px; font-family: var(--f-sans); font-size: 14px; outline: none; }
.filter-bar input:focus, .filter-bar select:focus { border-color: var(--gold); }
.filter-bar button { padding: 10px 18px; background: var(--ink); color: var(--white); border: none; border-radius: 3px; font-family: var(--f-sans); font-size: 12px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; cursor: pointer; transition: all 0.2s; }
.filter-bar button:hover { background: var(--gold); color: var(--ink); }

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
.badge-cat { background: var(--gold-pale); color: var(--gold); }

/* Actions */
.btn-sm { display: inline-flex; align-items: center; gap: 6px; padding: 6px 14px; border-radius: 3px; font-size: 11px; font-weight: 700; letter-spacing: 0.5px; text-transform: uppercase; text-decoration: none; transition: all 0.2s; border: none; cursor: pointer; }
.btn-edit { background: var(--paper); color: var(--ink-muted); }
.btn-edit:hover { background: var(--ink); color: var(--white); }
.btn-delete { background: #FEF2F2; color: #DC2626; }
.btn-delete:hover { background: #DC2626; color: var(--white); }
.btn-add { display: inline-flex; align-items: center; gap: 8px; padding: 12px 24px; background: var(--gold); color: var(--ink); border: none; border-radius: 2px; font-family: var(--f-sans); font-size: 11px; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; text-decoration: none; transition: all 0.25s; }
.btn-add:hover { background: var(--gold-lt); transform: translateY(-1px); box-shadow: 0 8px 24px rgba(184,150,62,0.35); }

/* Pagination */
.pagination { display: flex; justify-content: center; gap: 6px; padding: 20px; }
.pagination a, .pagination span { padding: 8px 14px; border: 1px solid var(--border); border-radius: 3px; font-size: 13px; font-weight: 600; color: var(--ink-muted); text-decoration: none; transition: all 0.2s; }
.pagination a:hover { border-color: var(--gold); color: var(--gold); }
.pagination .active { background: var(--gold); border-color: var(--gold); color: var(--ink); }

.empty { text-align: center; padding: 60px 20px; color: var(--slate); font-size: 14px; }
.empty i { font-size: 40px; margin-bottom: 16px; display: block; color: var(--border); }
.empty h3 { font-family: 'Cormorant Garamond', serif; font-size: 1.3rem; font-weight: 600; color: var(--ink); margin-bottom: 6px; }

.alert { padding: 12px 16px; border-radius: 3px; font-size: 13px; margin-bottom: 20px; }
.alert-success { background: #ECFDF5; color: #059669; border-left: 3px solid #059669; }
.alert-error { background: #FEF2F2; color: #DC2626; border-left: 3px solid #DC2626; }
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
        <h1>Expenses</h1>
        <p>Track and manage your business expenses.</p>
      </div>
      <a href="{{ route('pos.expenses.create') }}" class="btn-add"><i class="fas fa-plus"></i> Add Expense</a>
    </div>

    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
      <div class="alert alert-error">{{ session('error') }}</div>
    @endif

    <div class="stats-bar">
      <div class="stat-pill">
        <span class="stat-pill__val">${{ number_format($totalAmount, 2) }}</span>
        <span class="stat-pill__lbl">Total Expenses</span>
      </div>
      <div class="stat-pill">
        <span class="stat-pill__val">{{ $expenses->total() }}</span>
        <span class="stat-pill__lbl">Records</span>
      </div>
    </div>

    <form method="GET" action="{{ route('pos.expenses') }}" class="filter-bar">
      <input type="date" name="date_from" value="{{ request('date_from') }}" placeholder="From">
      <input type="date" name="date_to" value="{{ request('date_to') }}" placeholder="To">
      <select name="category">
        <option value="">All Categories</option>
        @foreach($categories as $cat)
          <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
        @endforeach
      </select>
      <button type="submit">Filter</button>
      <a href="{{ route('pos.expenses') }}" style="font-size:12px;color:var(--slate);text-decoration:none;">Clear</a>
    </form>

    <div class="table-wrap">
      @if($expenses->count() > 0)
        <table>
          <thead>
            <tr>
              <th>Expense #</th>
              <th>Date</th>
              <th>Category</th>
              <th>Description</th>
              <th>Amount</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            @foreach($expenses as $expense)
              <tr>
                <td><strong>{{ $expense->expense_number }}</strong></td>
                <td>{{ $expense->expense_date->format('M d, Y') }}</td>
                <td><span class="badge badge-cat">{{ $expense->category }}</span></td>
                <td>{{ $expense->description }}</td>
                <td><strong>${{ number_format($expense->amount, 2) }}</strong></td>
                <td>
                  <div style="display:flex;gap:6px;">
                    <a href="{{ route('pos.expenses.edit', $expense) }}" class="btn-sm btn-edit"><i class="fas fa-pen"></i></a>
                    <form method="POST" action="{{ route('pos.expenses.destroy', $expense) }}" onsubmit="return confirm('Delete this expense?');" style="display:inline;">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn-sm btn-delete"><i class="fas fa-trash"></i></button>
                    </form>
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>

        <div class="pagination">
          {{ $expenses->links() }}
        </div>
      @else
        <div class="empty">
          <i class="fas fa-file-invoice-dollar"></i>
          <h3>No expenses yet</h3>
          <p>Your expense records will appear here once you add your first expense.</p>
        </div>
      @endif
    </div>
  </div>
</div>

</body>
</html>

