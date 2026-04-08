@extends('layouts.app')

@section('title', 'Pay Escrow - ' . $bid->job->title)

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Pay Escrow to Accept Bid</h4>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning">
                        <strong>Escrow Amount: ${{ number_format($bid->amount, 2) }}</strong><br>
                        This holds payment until job completion.
                    </div>
                    <div class="mb-4">
                        <h5>Job Details</h5>
                        <p><strong>Title:</strong> {{ $bid->job->title }}</p>
                        <p><strong>Professional:</strong> {{ $bid->professional->name }}</p>
                        <p><strong>Bid Amount:</strong> ${{ number_format($bid->amount, 2) }}</p>
                    </div>
                    <form action="{{ route('client.accept-bid', $bid) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Payment Method</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" value="wallet" id="wallet" checked>
                                <label class="form-check-label" for="wallet">
                                    Wallet ({{ auth()->user()->wallet->balance ?? 0 }} available)
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" value="stripe" id="stripe">
                                <label class="form-check-label" for="stripe">
                                    Card
                                </label>
                            </div>
                        </div>
                        <div id="card-element" class="{{ auth()->user()->wallet && auth()->user()->wallet->balance >= $bid->amount ? 'd-none' : '' }}"></div>
                        <button type="submit" class="btn btn-primary w-100" id="pay-btn">
                            <i class="fas fa-lock"></i> Pay ${{ number_format($bid->amount, 2) }} Escrow
                        </button>
                    </form>
                    <div class="text-center mt-3">
                        <a href="{{ route('client.job-bids', $bid->project_job_id) }}" class="btn btn-outline-secondary">
                            Cancel
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

