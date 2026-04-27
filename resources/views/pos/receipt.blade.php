<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Receipt {{ $sale->sale_number }} — OWERU POS</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=Courier+Prime:wght@400;700&display=swap" rel="stylesheet">
<style>
:root {
  --ink: #0C0F14; --ink-soft: #1A1F2B; --ink-muted: #3D4455;
  --paper: #F5F2EC; --cream: #FAF8F4;
  --gold: #B8963E; --gold-lt: #D4AF5E;
  --white: #FFFFFF; --slate: #6B7385;
}
* { margin:0; padding:0; box-sizing:border-box; }
body { font-family: 'Syne', sans-serif; background: var(--cream); color: var(--ink); -webkit-font-smoothing: antialiased; display: flex; align-items: center; justify-content: center; min-height: 100vh; padding: 40px 20px; }
.receipt { background: var(--white); max-width: 420px; width: 100%; padding: 40px 32px; box-shadow: 0 20px 60px rgba(12,15,20,0.12); }
.receipt-header { text-align: center; margin-bottom: 28px; padding-bottom: 24px; border-bottom: 2px dashed var(--paper); }
.receipt-header h2 { font-size: 18px; font-weight: 800; letter-spacing: 3px; margin-bottom: 6px; }
.receipt-header p { font-size: 12px; color: var(--slate); }
.receipt-meta { margin-bottom: 20px; }
.meta-row { display: flex; justify-content: space-between; font-size: 12px; margin-bottom: 6px; color: var(--ink-muted); }
.meta-row span:first-child { font-weight: 600; color: var(--ink); }
.items { margin-bottom: 20px; }
.item-row { display: flex; justify-content: space-between; font-size: 13px; padding: 8px 0; border-bottom: 1px solid var(--paper); }
.item-row .desc { flex: 1; }
.item-row .desc strong { display: block; font-weight: 600; }
.item-row .desc small { color: var(--slate); font-size: 11px; }
.item-row .amt { text-align: right; min-width: 80px; font-weight: 600; }
.totals { margin-top: 16px; padding-top: 16px; border-top: 2px solid var(--ink); }
.total-row { display: flex; justify-content: space-between; font-size: 13px; margin-bottom: 8px; color: var(--ink-muted); }
.total-row.grand { font-size: 16px; font-weight: 700; color: var(--ink); margin-top: 8px; padding-top: 8px; border-top: 1px solid var(--paper); }
.total-row.change { color: var(--gold); font-weight: 700; }
.footer-note { text-align: center; margin-top: 28px; padding-top: 20px; border-top: 2px dashed var(--paper); font-size: 11px; color: var(--slate); }
.footer-note strong { display: block; font-size: 13px; color: var(--ink); margin-bottom: 4px; }
.actions { display: flex; gap: 10px; margin-top: 24px; justify-content: center; }
.btn { padding: 10px 20px; border-radius: 3px; font-family: 'Syne', sans-serif; font-size: 11px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; cursor: pointer; transition: all 0.2s; border: none; text-decoration: none; display: inline-block; }
.btn-print { background: var(--ink); color: var(--white); }
.btn-print:hover { background: var(--gold); color: var(--ink); }
.btn-back { background: var(--paper); color: var(--ink-muted); border: 1px solid var(--paper); }
.btn-back:hover { background: var(--border); }
@media print {
  body { background: white; padding: 0; }
  .receipt { box-shadow: none; max-width: 100%; }
  .actions { display: none; }
}
</style>
</head>
<body>

<div class="receipt">
  <div class="receipt-header">
    <h2>OWERU</h2>
    <p>BuildConnect POS</p>
  </div>

  <div class="receipt-meta">
    <div class="meta-row"><span>Receipt #</span><span>{{ $sale->sale_number }}</span></div>
    <div class="meta-row"><span>Date</span><span>{{ $sale->created_at->format('M d, Y H:i') }}</span></div>
    <div class="meta-row"><span>Cashier</span><span>{{ auth()->user()->name }}</span></div>
    @if($sale->customer_name)
      <div class="meta-row"><span>Customer</span><span>{{ $sale->customer_name }}</span></div>
    @endif
    @if($sale->customer_phone)
      <div class="meta-row"><span>Phone</span><span>{{ $sale->customer_phone }}</span></div>
    @endif
  </div>

  <div class="items">
    @foreach($sale->items as $item)
      <div class="item-row">
        <div class="desc">
          <strong>{{ $item->product_name }}</strong>
          <small>{{ $item->quantity }} x ${{ number_format($item->unit_price, 2) }}</small>
        </div>
        <div class="amt">${{ number_format($item->total_price, 2) }}</div>
      </div>
    @endforeach
  </div>

  <div class="totals">
    <div class="total-row"><span>Subtotal</span><span>${{ number_format($sale->subtotal, 2) }}</span></div>
    <div class="total-row"><span>Tax (18%)</span><span>${{ number_format($sale->tax_amount, 2) }}</span></div>
    <div class="total-row grand"><span>Total</span><span>${{ number_format($sale->total_amount, 2) }}</span></div>
    <div class="total-row"><span>Paid ({{ ucfirst(str_replace('_', ' ', $sale->payment_method)) }})</span><span>${{ number_format($sale->amount_paid, 2) }}</span></div>
    @if($sale->change_due > 0)
      <div class="total-row change"><span>Change Due</span><span>${{ number_format($sale->change_due, 2) }}</span></div>
    @endif
  </div>

  @if($sale->notes)
    <div style="margin-top:16px;font-size:12px;color:var(--slate);padding:12px;background:var(--cream);border-radius:3px;">
      <strong>Notes:</strong> {{ $sale->notes }}
    </div>
  @endif

  <div class="footer-note">
    <strong>Thank you for your business!</strong>
    <p>Powered by Oweru BuildConnect</p>
  </div>

  <div class="actions">
    <button class="btn btn-print" onclick="window.print()"><i class="fas fa-print" style="margin-right:6px;"></i>Print</button>
    <a href="{{ route('pos.sale') }}" class="btn btn-back">New Sale</a>
    <a href="{{ route('pos.single-shop') }}" class="btn btn-back">Dashboard</a>
  </div>
</div>

</body>
</html>

