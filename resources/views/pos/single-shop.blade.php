<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Single Shop POS — OWERU</title>
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
html { scroll-behavior: smooth; }
body { font-family: var(--f-sans); background: var(--cream); color: var(--ink); -webkit-font-smoothing: antialiased; }
a { text-decoration: none; color: inherit; }
.container { max-width: 1100px; margin: 0 auto; padding: 0 48px; }

/* Header */
.header { position: sticky; top: 0; z-index: 500; background: rgba(245,242,236,0.96); backdrop-filter: blur(20px); border-bottom: 1px solid var(--border); }
.header__row { display: flex; align-items: center; justify-content: space-between; height: 68px; }
.logo { display: flex; align-items: center; gap: 12px; }
.logo__mark { width: 38px; height: 38px; background: var(--ink); border-radius: 4px; display: flex; align-items: center; justify-content: center; }
.logo__name { font-family: var(--f-sans); font-size: 15px; font-weight: 800; letter-spacing: 3px; color: var(--ink); }
.logo__sub { font-size: 10px; font-weight: 400; letter-spacing: 2px; color: var(--gold); text-transform: uppercase; }
.back-link { font-size: 12.5px; font-weight: 600; letter-spacing: 0.8px; color: var(--ink-muted); text-transform: uppercase; transition: color 0.2s; }
.back-link:hover { color: var(--gold); }

/* Hero */
.hero { background: var(--ink); padding: 80px 0; position: relative; overflow: hidden; }
.hero::before { content: ''; position: absolute; inset: 0; background: radial-gradient(ellipse at 20% 50%, rgba(184,150,62,0.1) 0%, transparent 55%); }
.hero__inner { position: relative; z-index: 1; }
.hero__eyebrow { display: flex; align-items: center; gap: 10px; margin-bottom: 20px; }
.hero__eyebrow-line { width: 24px; height: 1.5px; background: var(--gold); }
.hero__eyebrow span { font-size: 11px; font-weight: 700; letter-spacing: 2.5px; text-transform: uppercase; color: var(--gold); }
.hero h1 { font-family: 'Cormorant Garamond', serif; font-size: clamp(2.2rem, 4.5vw, 3.5rem); font-weight: 300; line-height: 1.2; color: var(--white); letter-spacing: -1px; margin-bottom: 16px; }
.hero h1 em { font-style: italic; color: var(--gold-lt); }
.hero p { font-size: 15px; line-height: 1.75; color: rgba(255,255,255,0.5); max-width: 520px; }

/* Cards */
.cards { padding: 60px 0; }
.cards__grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 24px; }
.card { background: var(--white); border: 1px solid var(--border); border-radius: 3px; padding: 36px 32px; transition: all 0.3s var(--ease); position: relative; overflow: hidden; }
.card::after { content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 3px; background: var(--gold); transform: scaleX(0); transform-origin: left; transition: transform 0.3s var(--ease); }
.card:hover { box-shadow: 0 12px 40px rgba(12,15,20,0.08); transform: translateY(-3px); }
.card:hover::after { transform: scaleX(1); }
.card__icon { width: 52px; height: 52px; background: var(--gold-pale); border-radius: 2px; display: flex; align-items: center; justify-content: center; color: var(--gold); font-size: 22px; margin-bottom: 22px; }
.card h3 { font-family: 'Cormorant Garamond', serif; font-size: 1.4rem; font-weight: 600; color: var(--ink); margin-bottom: 8px; }
.card p { font-size: 13.5px; color: var(--slate); line-height: 1.6; margin-bottom: 24px; }
.btn { display: inline-flex; align-items: center; gap: 8px; font-family: var(--f-sans); font-size: 11px; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; padding: 12px 24px; border: none; border-radius: 2px; cursor: pointer; transition: all 0.25s var(--ease); white-space: nowrap; }
.btn--gold { background: var(--gold); color: var(--ink); }
.btn--gold:hover { background: var(--gold-lt); transform: translateY(-1px); box-shadow: 0 8px 24px rgba(184,150,62,0.35); }
.btn--outline { background: transparent; border: 1.5px solid var(--ink); color: var(--ink); }
.btn--outline:hover { background: var(--ink); color: var(--cream); }

/* Footer note */
.footer-note { padding: 40px 0 80px; text-align: center; font-size: 12px; color: var(--slate); }
</style>
</head>
<body>

<header class="header">
  <div class="container">
    <div class="header__row">
      <a href="/" class="logo">
        <div class="logo__mark">
          <svg width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M3 15 L7 5 L10 10 L13 7 L17 15" stroke="#C9A84C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </div>
        <div>
          <div class="logo__name">OWERU</div>
          <div class="logo__sub">BuildConnect</div>
        </div>
      </a>
      <a href="/" class="back-link">← Back to Home</a>
    </div>
  </div>
</header>

<section class="hero">
  <div class="container">
    <div class="hero__inner">
      <div class="hero__eyebrow"><div class="hero__eyebrow-line"></div><span>Point of Sale</span></div>
      <h1>Single Shop <em>Management</em></h1>
      <p>Manage one store effortlessly — products, inventory, sales, and reporting all in one place.</p>
    </div>
  </div>
</section>

<section class="cards">
  <div class="container">
    <div class="cards__grid">
      <div class="card">
        <div class="card__icon"><i class="fas fa-cash-register"></i></div>
        <h3>New Sale</h3>
        <p>Quickly scan or search products, add them to the cart, and process checkout in seconds.</p>
        <a href="{{ route('pos.sale') }}" class="btn btn--gold">Start Selling →</a>
      </div>
      <div class="card">
        <div class="card__icon"><i class="fas fa-history"></i></div>
        <h3>Sales History</h3>
        <p>Review all your past transactions, reprint receipts, and track your selling activity.</p>
        <a href="{{ route('pos.history') }}" class="btn btn--gold">View History →</a>
      </div>
      <div class="card">
        <div class="card__icon"><i class="fas fa-chart-bar"></i></div>
        <h3>Daily Report</h3>
        <p>See your daily revenue, items sold, payment breakdowns, and tax summaries.</p>
        <a href="{{ route('pos.daily-report') }}" class="btn btn--gold">Open Report →</a>
      </div>
      <div class="card">
        <div class="card__icon"><i class="fas fa-receipt"></i></div>
        <h3>Recent Receipts</h3>
        <p>Access the latest receipts from today’s sales for refunds or customer queries.</p>
        <a href="{{ route('pos.history') }}" class="btn btn--gold">View Receipts →</a>
      </div>
    </div>
  </div>
</section>

<div class="container">
  <div class="footer-note">
    <p>Need more stores? <a href="{{ route('pos.multi-shop') }}" style="color:var(--gold); font-weight:600;">Switch to Multi-Shop Management →</a></p>
  </div>
</div>

</body>
</html>

