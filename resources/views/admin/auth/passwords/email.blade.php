<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Reset Admin Password - Oweru</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@300;400;500;600;700;800&family=Nunito:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-dark: #0F172A;
            --soft-white: #F8F8F9;
            --gold-accent: #C9A53B;
        }
        
        body {
            font-family: 'Raleway', sans-serif;
            background: linear-gradient(135deg, var(--primary-dark) 0%, #1a2639 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 20px;
        }
        
        .reset-container {
            max-width: 450px;
            width: 100%;
        }
        
        .reset-card {
            background: var(--soft-white);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            animation: fadeInUp 0.6s ease;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .logo {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .logo img {
            height: 70px;
            width: auto;
            margin-bottom: 15px;
        }
        
        .logo h3 {
            font-family: 'Nunito', sans-serif;
            font-weight: 800;
            color: var(--primary-dark);
            margin: 0;
        }
        
        .logo span {
            color: var(--gold-accent);
        }
        
        .form-label {
            font-weight: 600;
            color: var(--primary-dark);
        }
        
        .form-control {
            border-radius: 10px;
            padding: 12px 15px;
            border: 2px solid #e5e5e5;
        }
        
        .form-control:focus {
            border-color: var(--gold-accent);
            box-shadow: 0 0 0 3px rgba(201,165,59,0.2);
        }
        
        .btn-reset {
            background: var(--primary-dark);
            color: var(--soft-white);
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            width: 100%;
            transition: all 0.3s;
        }
        
        .btn-reset:hover {
            background: var(--gold-accent);
            color: var(--primary-dark);
            transform: translateY(-2px);
        }
        
        .btn-back {
            background: transparent;
            color: var(--primary-dark);
            border: 2px solid var(--primary-dark);
            border-radius: 10px;
            padding: 10px;
            font-weight: 600;
            width: 100%;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }
        
        .btn-back:hover {
            background: var(--primary-dark);
            color: var(--soft-white);
        }
        
        .alert {
            border-radius: 10px;
            border-left: 4px solid;
        }
    </style>
</head>
<body>
    <div class="reset-container">
        <div class="reset-card">
            <div class="logo">
                <img src="{{ asset('logo-white.png') }}" alt="Oweru">
                <h3>Oweru<span>.</span></h3>
                <p class="text-muted mt-2">Admin Password Reset</p>
            </div>
            
            @if(session('status'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle me-2"></i>{{ session('status') }}
                </div>
            @endif
            
            @if($errors->any())
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ $errors->first() }}
                </div>
            @endif
            
            <p class="text-muted mb-4">Enter your email address and we'll send you a link to reset your password.</p>
            
            <form method="POST" action="{{ route('admin.password.email') }}">
                @csrf
                
                <div class="mb-4">
                    <label class="form-label">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0">
                            <i class="fas fa-envelope" style="color: var(--gold-accent);"></i>
                        </span>
                        <input type="email" name="email" class="form-control border-start-0" 
                               value="{{ old('email') }}" required autofocus>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-reset mb-3">
                    <i class="fas fa-paper-plane me-2"></i>Send Password Reset Link
                </button>
                
                <a href="{{ route('admin.login') }}" class="btn-back">
                    <i class="fas fa-arrow-left me-2"></i>Back to Login
                </a>
            </form>
        </div>
    </div>
</body>
</html>