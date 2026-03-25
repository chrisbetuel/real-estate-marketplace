@extends('layouts.app')

@section('title', 'Reset Password - Oweru')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-transparent border-0 pt-4 text-center">
                    <i class="fas fa-lock fa-3x mb-3" style="color: var(--gold-accent);"></i>
                    <h3 class="mb-0">Create New Password</h3>
                    <p class="text-muted mt-2">Enter your new password</p>
                </div>
                
                <div class="card-body p-4">
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            {{ $errors->first() }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-envelope" style="color: var(--gold-accent);"></i>
                                </span>
                                <input type="email" name="email" class="form-control" 
                                       value="{{ $email ?? old('email') }}" required readonly>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold">New Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-lock" style="color: var(--gold-accent);"></i>
                                </span>
                                <input type="password" name="password" id="password" class="form-control" required>
                                <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <div class="password-strength mt-2" id="passwordStrength"></div>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Confirm New Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-check-circle" style="color: var(--gold-accent);"></i>
                                </span>
                                <input type="password" name="password_confirmation" class="form-control" required>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100 py-2 mb-3" style="background: var(--gold-accent); border: none; color: var(--primary-dark);">
                            <i class="fas fa-save me-2"></i>Reset Password
                        </button>
                        
                        <div class="text-center">
                            <a href="{{ route('login') }}" class="text-decoration-none">
                                <i class="fas fa-arrow-left me-1"></i>Back to Login
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    :root {
        --primary-dark: #0F172A;
        --gold-accent: #C9A53B;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(201, 165, 59, 0.3);
        background: var(--gold-accent) !important;
    }
    
    .form-control:focus {
        border-color: var(--gold-accent);
        box-shadow: 0 0 0 0.2rem rgba(201, 165, 59, 0.25);
    }
    
    .password-strength {
        font-size: 0.85rem;
    }
    
    .strength-weak { color: #dc3545; }
    .strength-medium { color: #fd7e14; }
    .strength-strong { color: #28a745; }
</style>
@endpush

@push('scripts')
<script>
    // Password strength checker
    const passwordInput = document.getElementById('password');
    const strengthDiv = document.getElementById('passwordStrength');
    
    if (passwordInput && strengthDiv) {
        passwordInput.addEventListener('input', function() {
            const password = this.value;
            
            if (password.length === 0) {
                strengthDiv.innerHTML = '';
                return;
            }
            
            let strength = 'weak';
            let message = '';
            
            if (password.length >= 8 && /[A-Z]/.test(password) && /[0-9]/.test(password) && /[^a-zA-Z0-9]/.test(password)) {
                strength = 'strong';
                message = '✓ Strong password!';
            } else if (password.length >= 6 && (/[A-Z]/.test(password) || /[0-9]/.test(password))) {
                strength = 'medium';
                message = '⚠️ Medium strength - add uppercase letters, numbers and symbols';
            } else {
                message = '❌ Weak - use at least 8 characters with uppercase, numbers and symbols';
            }
            
            strengthDiv.innerHTML = `<span class="strength-${strength}"><i class="fas ${strength === 'strong' ? 'fa-check-circle' : strength === 'medium' ? 'fa-exclamation-triangle' : 'fa-times-circle'} me-1"></i>${message}</span>`;
        });
    }
    
    // Toggle password visibility
    const togglePassword = document.getElementById('togglePassword');
    if (togglePassword && passwordInput) {
        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.querySelector('i').classList.toggle('fa-eye');
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });
    }
</script>
@endpush
@endsection