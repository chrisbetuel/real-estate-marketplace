
<!DOCTYPE html>
@extends('layouts.app')

@section('title', 'Terms & Conditions - BuildConnect')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow">
                <div class="card-body p-5">
                    <h1 class="mb-4">Terms & Conditions</h1>
                    <p class="text-muted small mb-4">Last updated: {{ date('F Y') }}</p>
                    
                    <div class="mb-5">
                        <h3 class="h5 fw-bold mb-3">1. Acceptance of Terms</h3>
                        <p>By accessing and using BuildConnect, you accept these terms. If you do not agree, please do not use the platform.</p>
                    </div>
                    
                    <div class="mb-5">
                        <h3 class="h5 fw-bold mb-3">2. User Accounts</h3>
                        <p>You must provide accurate information and keep your account secure. You are responsible for all activity on your account.</p>
                    </div>
                    
                    <div class="mb-5">
                        <h3 class="h5 fw-bold mb-3">3. Platform Use</h3>
                        <p>Do not misuse the platform, spam, or post illegal content. We reserve the right to suspend accounts for violations.</p>
                    </div>
                    
                    <div class="mb-5">
                        <h3 class="h5 fw-bold mb-3">4. Payments & Transactions</h3>
                        <p>All transactions use escrow for security. BuildConnect is not responsible for disputes between users.</p>
                    </div>
                    
                    <div class="mb-5">
                        <h3 class="h5 fw-bold mb-3">5. Termination</h3>
                        <p>We may terminate your access at any time for violation of terms or at our discretion.</p>
                    </div>
                    
                    <div class="mb-5">
                        <h3 class="h5 fw-bold mb-3">6. Governing Law</h3>
                        <p>These terms are governed by the laws of Tanzania.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection>

