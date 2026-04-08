<!DOCTYPE html>
@extends('layouts.app')

@section('title', 'Disclaimer - BuildConnect')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow">
                <div class="card-body p-5">
                    <h1 class="mb-4">Disclaimer</h1>
                    <div class="mb-4">
                        <h3 class="h5 fw-bold mb-3">1. No Warranties</h3>
                        <p>BuildConnect provides the platform "as is" without warranties of any kind, express or implied.</p>
                    </div>
                    <div class="mb-4">
                        <h3 class="h5 fw-bold mb-3">2. Third Party Content</h3>
                        <p>We do not endorse or guarantee user-generated content, products, or services listed on the platform.</p>
                    </div>
                    <div class="mb-4">
                        <h3 class="h5 fw-bold mb-3">3. Limitation of Liability</h3>
                        <p>BuildConnect is not liable for any damages arising from use of the platform or transactions between users.</p>
                    </div>
                    <div class="mb-4">
                        <h3 class="h5 fw-bold mb-3">4. User Responsibility</h3>
                        <p>Users are responsible for verifying professionals, products, and conducting their own due diligence.</p>
                    </div>
                    <p class="text-muted mt-4">Last updated: {{ date('F Y') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection>

