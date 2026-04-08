
<!DOCTYPE html>
@extends('layouts.app')

@section('title', 'Privacy Policy - BuildConnect')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow">
                <div class="card-body p-5">
                    <h1 class="mb-4">Privacy Policy</h1>
                    <p class="text-muted small mb-4">Last updated: {{ date('F Y') }}</p>
                    
                    <div class="mb-5">
                        <h3 class="h5 fw-bold mb-3">1. Information We Collect</h3>
                        <p>We collect personal information like name, email, phone, and payment details when you create an account or use our services.</p>
                    </div>
                    
                    <div class="mb-5">
                        <h3 class="h5 fw-bold mb-3">2. How We Use Information</h3>
                        <p>Your information is used to provide services, process payments, communicate with you, and improve our platform.</p>
                    </div>
                    
                    <div class="mb-5">
                        <h3 class="h5 fw-bold mb-3">3. Data Sharing</h3>
                        <p>We share information with service providers and professionals for job completion. We never sell your data.</p>
                    </div>
                    
                    <div class="mb-5">
                        <h3 class="h5 fw-bold mb-3">4. Cookies & Tracking</h3>
                        <p>We use cookies for functionality and analytics. You can manage cookie preferences in your browser.</p>
                    </div>
                    
                    <div class="mb-5">
                        <h3 class="h5 fw-bold mb-3">5. Your Rights</h3>
                        <p>You can access, update, or delete your data by contacting support@buildconnect.com.</p>
                    </div>
                    
                    <div class="mb-5">
                        <h3 class="h5 fw-bold mb-3">6. Data Security</h3>
                        <p>We use industry-standard security to protect your data, but no system is 100% secure.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection>

