@extends('layouts.app')

@section('title', 'Unlock Professional Details - {{ $professional->name }}')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Unlock Full Professional Details</h4>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Unlock Fee: ${{ number_format($unlockFee, 2) }}</strong><br>
                        Pay this fee to access full contact details (email, phone, address) and connect with this professional.
                    </div>

                    <div class="mb-4">
                        <h5>Professional Details</h5>
                        <p><strong>Name:</strong> {{ $professional->name }}</p>
                        <p><strong>Profession:</strong> {{ $professional->professionalProfile->profession ?? 'N/A' }}</p>
                        <p><strong>Rating:</strong> {{ number_format($professional->rating, 1) }} ({{ $professional->reviews_count }} reviews)</p>
                        <div class="text-muted small mt-2">
                            <em>Details currently masked. Pay to unlock full information.</em>
                        </div>
                    </div>

                    <form action="{{ route('payment.process-professional-unlock', $professional) }}" method="POST" id="payment-form">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label">Payment Method</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" value="wallet" id="wallet" checked>
                                <label class="form-check-label" for="wallet">
                                    Wallet Balance ({{ auth()->user()->wallet->balance ?? 0 }})
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" value="stripe" id="stripe">
                                <label class="form-check-label" for="stripe">
                                    Credit / Debit Card
                                </label>
                            </div>
                        </div>

                        <div class="mb-4" id="card-element" style="display: none;">
                            <!-- Stripe Elements will mount here -->
                            <div id="card-element"></div>
                            <div id="card-errors" class="text-danger mt-2"></div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary-custom" id="submit-btn">
                                Pay ${{ number_format($unlockFee, 2) }} & Unlock Details
                            </button>
                            <a href="{{ route('professionals.show', $professional) }}" class="btn btn-outline-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://js.stripe.com/v3/"></script>
<script>
    const stripe = Stripe('{{ config('services.stripe.key') }}');
    const elements = stripe.elements();
    const cardElement = elements.create('card');
    
    document.querySelector('input[name="payment_method"]').addEventListener('change', function() {
        if (this.value === 'stripe') {
            document.getElementById('card-element').style.display = 'block';
            cardElement.mount('#card-element');
        } else {
            document.getElementById('card-element').style.display = 'none';
            cardElement.unmount();
        }
    });

    const form = document.getElementById('payment-form');
    const submitBtn = document.getElementById('submit-btn');

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;
        if (paymentMethod === 'stripe') {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Processing...';
            
            const { token, error } = await stripe.createToken(cardElement);
            
            if (error) {
                document.getElementById('card-errors').textContent = error.message;
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'Pay & Unlock Details';
            } else {
                const hiddenInput = document.createElement('input');
                hiddenInput.setAttribute('type', 'hidden');
                hiddenInput.setAttribute('name', 'stripe_token');
                hiddenInput.setAttribute('value', token.id);
                form.appendChild(hiddenInput);
                form.submit();
            }
        } else {
            form.submit();
        }
    });
</script>
@endpush
@endsection

