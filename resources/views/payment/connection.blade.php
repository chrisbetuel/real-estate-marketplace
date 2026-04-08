@extends('layouts.app')

@section('title', 'Pay to Connect - Oweru')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Connect with Professional</h4>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Connection Fee: ${{ number_format($connectionFee, 2) }}</strong><br>
                        This fee allows you to message and connect with the professional for this job.
                    </div>

                    <div class="mb-4">
                        <h5>Job Details</h5>
                        <p><strong>Title:</strong> {{ $job->title }}</p>
                        <p><strong>Budget:</strong> ${{ number_format($job->budget_min) }} - ${{ number_format($job->budget_max) }}</p>
                        <p><strong>Professional:</strong> {{ $job->assignedProfessional->name ?? 'To be assigned' }}</p>
                    </div>

                    <form action="{{ route('payment.process-connection', $job) }}" method="POST" id="payment-form">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label">Payment Method</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" value="wallet" id="wallet">
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

                        <div class="mb-4" id="card-element">
                            <!-- Stripe Elements will mount here -->
                            <div id="card-element"></div>
                            <div id="card-errors" class="text-danger mt-2"></div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary-custom" id="submit-btn">
                                Pay ${{ number_format($connectionFee, 2) }} & Connect
                            </button>
                            <a href="{{ route('jobs.show', $job) }}" class="btn btn-outline-secondary">Cancel</a>
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
    cardElement.mount('#card-element');

    const form = document.getElementById('payment-form');
    const submitBtn = document.getElementById('submit-btn');

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Processing...';
        
        const { token, error } = await stripe.createToken(cardElement);
        
        if (error) {
            document.getElementById('card-errors').textContent = error.message;
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'Pay & Connect';
        } else {
            const hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripe_token');
            hiddenInput.setAttribute('value', token.id);
            form.appendChild(hiddenInput);
            form.submit();
        }
    });
</script>
@endpush
@endsection

