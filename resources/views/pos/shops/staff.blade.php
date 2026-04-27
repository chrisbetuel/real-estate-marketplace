<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Staff — {{ $shop->name }} — OWERU POS</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;0,700&family=Syne:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
:root {
  --ink: #0C0F14; --ink-soft: #1A1F2B; --ink-muted: #3D4455;
  --paper: #F5F2EC; --paper-2: #EDE9E0; --cream: #FAF8F4;
  --gold: #B8963E; --gold-lt: #D4AF5E; --gold-pale: #F2EAD6;
  --white: #FFFFFF; --slate: #6B7385; --border: rgba(12,15,20,0.1);
  --danger: #DC2626;
  --f-sans: 'Syne', sans-serif;
  --ease: cubic-bezier(0.25, 0.46, 0.45, 0.94);
}
*, *::before, *::after { margin:0; padding:0; box-sizing:border-box; }
body { font-family: var(--f-sans); background: var(--cream); color: var(--ink); -webkit-font-smoothing: antialiased; }
a { text-decoration: none; color: inherit; }
.container { max-width: 800px; margin: 0 auto; padding: 0 32px; }

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

.form-card { background: var(--white); border: 1px solid var(--border); border-radius: 3px; padding: 24px; margin-bottom: 32px; }
.form-row { display: flex; gap: 12px; }
.form-group { flex: 1; margin-bottom: 0; }
.form-group label { display: block; font-size: 11px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; color: var(--ink-muted); margin-bottom: 8px; }
.form-group input, .form-group select {
  width: 100%; padding: 10px 12px; border: 1px solid var(--border); border-radius: 3px;
  font-family: var(--f-sans); font-size: 14px; outline: none; background: var(--cream);
}
.form-group input:focus, .form-group select:focus { border-color: var(--gold); }

.btn { display: inline-flex; align-items: center; gap: 8px; font-family: var(--f-sans); font-size: 12px; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; padding: 10px 20px; border: none; border-radius: 2px; cursor: pointer; transition: all 0.25s var(--ease); }
.btn--gold { background: var(--gold); color: var(--ink); }
.btn--gold:hover { background: var(--gold-lt); }
.btn--danger { background: #FEF2F2; color: var(--danger); border: 1px solid #FECACA; }
.btn--danger:hover { background: var(--danger); color: var(--white); }

.table-wrap { background: var(--white); border: 1px solid var(--border); border-radius: 3px; overflow: hidden; }
table { width: 100%; border-collapse: collapse; }
th { text-align: left; padding: 12px 16px; font-size: 10px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; color: var(--ink-muted); background: var(--paper); border-bottom: 1px solid var(--border); }
td { padding: 12px 16px; font-size: 13px; border-bottom: 1px solid var(--border); }
tr:last-child td { border-bottom: none; }
.badge { font-size: 10px; font-weight: 700; padding: 3px 10px; border-radius: 20px; text-transform: uppercase; }
.badge--gold { background: var(--gold-pale); color: var(--gold); }
.badge--manager { background: #EFF6FF; color: #2563EB; }
.badge--cashier { background: #F3F4F6; color: var(--ink-muted); }
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
    <h1>Shop <em>Staff</em></h1>
    <p>Manage who can access and operate this shop.</p>

    @if(in_array($role, ['admin', 'manager']))
    <form method="POST" action="{{ route('pos.shops.staff.store', $shop) }}" class="form-card">
      @csrf
      <div class="form-row">
        <div class="form-group" style="flex:2;">
          <label>User Email</label>
          <input type="email" name="email" placeholder="user@example.com" required>
        </div>
        <div class="form-group">
          <label>Role</label>
          <select name="role" required>
            <option value="manager">Manager</option>
            <option value="cashier">Cashier</option>
          </select>
        </div>
        <div style="display:flex;align-items:flex-end;">
          <button type="submit" class="btn btn--gold"><i class="fas fa-plus"></i> Add</button>
        </div>
      </div>
    </form>
    @endif

    <div class="table-wrap">
      <table>
        <thead>
          <tr><th>Name</th><th>Email</th><th>Role</th>@if(in_array($role, ['admin', 'manager']))<th></th>@endif</tr>
        </thead>
        <tbody>
          <tr>
            <td><strong>{{ $shop->owner->name }}</strong></td>
            <td>{{ $shop->owner->email }}</td>
            <td><span class="badge badge--gold">Admin</span></td>
            @if(in_array($role, ['admin', 'manager']))<td></td>@endif
          </tr>
          @forelse($staff as $member)
          <tr>
            <td>{{ $member->name }}</td>
            <td>{{ $member->email }}</td>
            <td>
              @if($member->pivot->role === 'manager')
                <span class="badge badge--manager">Manager</span>
              @else
                <span class="badge badge--cashier">Cashier</span>
              @endif
            </td>
            @if(in_array($role, ['admin', 'manager']))
            <td>
              <form method="POST" action="{{ route('pos.shops.staff.remove', [$shop, $member]) }}" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn--danger" style="padding:6px 12px;font-size:10px;" onclick="return confirm('Remove this staff member?')">
                  <i class="fas fa-trash-alt"></i>
                </button>
              </form>
            </td>
            @endif
          </tr>
          @empty
          <tr><td colspan="{{ in_array($role, ['admin', 'manager']) ? 4 : 3 }}" style="text-align:center;color:var(--slale);">No additional staff members.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

</body>
</html>

