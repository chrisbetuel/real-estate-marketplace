<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Stock Transfer — OWERU POS</title>
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
.container { max-width: 600px; margin: 0 auto; padding: 0 24px; }

.header { position: sticky; top: 0; z-index: 500; background: rgba(245,242,236,0.96); backdrop-filter: blur(20px); border-bottom: 1px solid var(--border); }
.header__row { display: flex; align-items: center; justify-content: space-between; height: 60px; }
.logo { display: flex; align-items: center; gap: 10px; }
.logo__mark { width: 32px; height: 32px; background: var(--ink); border-radius: 4px; display: flex; align-items: center; justify-content: center; }
.logo__name { font-size: 14px; font-weight: 800; letter-spacing: 2px; }
.back-link { font-size: 12px; font-weight: 600; letter-spacing: 0.8px; color: var(--ink-muted); text-transform: uppercase; }
.back-link:hover { color: var(--gold); }

.page { padding: 48px 0; }
.page h1 { font-family: 'Cormorant Garamond', serif; font-size: 2rem; font-weight: 300; margin-bottom: 8px; }
.page p { color: var(--slate); font-size: 14px; margin-bottom: 32px; }

.form-card { background: var(--white); border: 1px solid var(--border); border-radius: 3px; padding: 32px; }
.form-group { margin-bottom: 20px; }
.form-group label { display: block; font-size: 11px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; color: var(--ink-muted); margin-bottom: 8px; }
.form-group input, .form-group select, .form-group textarea {
  width: 100%; padding: 12px 14px; border: 1px solid var(--border); border-radius: 3px;
  font-family: var(--f-sans); font-size: 14px; outline: none; background: var(--cream);
}
.form-group input:focus, .form-group select:focus, .form-group textarea:focus { border-color: var(--gold); }
.form-group textarea { resize: vertical; min-height: 80px; }

.btn { display: inline-flex; align-items: center; gap: 8px; font-family: var(--f-sans); font-size: 12px; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; padding: 14px 28px; border: none; border-radius: 2px; cursor: pointer; transition: all 0.25s var(--ease); }
.btn--gold { background: var(--gold); color: var(--ink); }
.btn--gold:hover { background: var(--gold-lt); }
.btn--outline { background: transparent; border: 1.5px solid var(--ink); color: var(--ink); }
.btn--outline:hover { background: var(--ink); color: var(--cream); }

.actions { display: flex; gap: 12px; margin-top: 24px; }
</style>
</head>
<body>

<header class="header">
  <div class="container" style="max-width:600px;">
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
    <h1>Stock <em>Transfer</em></h1>
    <p>Move inventory between your shops.</p>

    <form method="POST" action="{{ route('pos.transfers.store') }}" class="form-card">
      @csrf
      <div class="form-group">
        <label>From Shop *</label>
        <select name="from_shop_id" required>
          <option value="">Select source shop</option>
          @foreach($shops as $s)
          <option value="{{ $s->id }}">{{ $s->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group">
        <label>To Shop *</label>
        <select name="to_shop_id" required>
          <option value="">Select destination shop</option>
          @foreach($shops as $s)
          <option value="{{ $s->id }}">{{ $s->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group">
        <label>Product *</label>
        <select name="product_id" required>
          <option value="">Select product</option>
          @foreach($products as $p)
          <option value="{{ $p->id }}">{{ $p->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group">
        <label>Quantity *</label>
        <input type="number" name="quantity" min="1" required placeholder="0">
      </div>
      <div class="form-group">
        <label>Notes</label>
        <textarea name="notes" placeholder="Optional notes..."></textarea>
      </div>
      <div class="actions">
        <a href="{{ route('pos.multi-shop') }}" class="btn btn--outline">Cancel</a>
        <button type="submit" class="btn btn--gold"><i class="fas fa-exchange-alt"></i> Transfer Stock</button>
      </div>
    </form>
  </div>
</div>

</body>
</html>

