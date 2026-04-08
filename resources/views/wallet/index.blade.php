@extends('layouts.app')

@section('title', 'My Wallet - Oweru')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Wallet Balance</h5>
                </div>
                <div class="card-body text-center">
                    <h2 class="text-oweru-gold">${{ number_format(Auth::user()->wallet->balance ?? 0, 2) }}</h2>
                    <p class="text-muted">Available Balance</p>
                    <button class="btn btn-primary-custom" data-bs-toggle="modal" data-bs-target="#addFundsModal">
                        <i class="fas fa-plus-circle me-2"></i>Add Funds
                    </button>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Recent Transactions</h5>
                </div>
                <div class="card-body">
                    @if($transactions->count() > 0)
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Description</th>
                                        <th>Amount</th>
                                        <th>Type</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($transactions as $transaction)
                                    <tr>
                                        <td>{{ $transaction->created_at->format('M d, Y') }}</td>
                                        <td>{{ $transaction->description }}</td>
                                        <td class="fw-semibold {{ $transaction->type == 'deposit' ? 'text-success' : 'text-danger' }}">
                                            {{ $transaction->type == 'deposit' ? '+' : '-' }}${{ number_format($transaction->amount, 2) }}
                                        </td>
                                        <td>{{ ucfirst($transaction->type) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted text-center">No transactions yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Funds Modal -->
<div class="modal fade" id="addFundsModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Funds to Wallet</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('payment.add-funds') }}" method="POST" id="funds-form">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Amount ($)</label>
                        <input type="number" name="amount" class="form-control" required min="10" step="1">
                        <small class="text-muted">Minimum $10</small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Card Details</label>
                        <div id="card-element-funds"></div>
                        <div id="card-errors-funds" class="text-danger mt-2"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary-custom" id="add-funds-btn">
                        Add Funds
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://js.stripe.com/v3/"></script>
<script>
    const stripeFunds = Stripe('{{ config('services.stripe.key') }}');
    const elementsFunds = stripeFunds.elements();
    const cardFunds = elementsFunds.create('card');
    cardFunds.mount('#card-element-funds');

    const fundsForm = document.getElementById('funds-form');
    const addFundsBtn = document.getElementById('add-funds-btn');

    fundsForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        addFundsBtn.disabled = true;
        addFundsBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Processing...';
        
        const { token, error } = await stripeFunds.createToken(cardFunds);
        
        if (error) {
            document.getElementById('card-errors-funds').textContent = error.message;
            addFundsBtn.disabled = false;
            addFundsBtn.innerHTML = 'Add Funds';
        } else {
            const hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripe_token');
            hiddenInput.setAttribute('value', token.id);
            fundsForm.appendChild(hiddenInput);
            fundsForm.submit();
        }
    });
</script>
@endpush
@endsection

