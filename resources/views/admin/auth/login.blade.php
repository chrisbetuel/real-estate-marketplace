<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Login - Oweru Real Estate</title>
    
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
            --light-grey: #E5E5E5;
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
        
        .login-container {
            max-width: 450px;
            width: 100%;
        }
        
        .login-card {
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
        
        .logo p {
            color: #6c757d;
            font-size: 0.9rem;
            margin-top: 5px;
        }
        
        .form-label {
            font-weight: 600;
            color: var(--primary-dark);
        }
        
        .form-control {
            border-radius: 10px;
            padding: 12px 15px;
            border: 2px solid var(--light-grey);
            transition: all 0.3s;
        }
        
        .form-control:focus {
            border-color: var(--gold-accent);
            box-shadow: 0 0 0 3px rgba(201,165,59,0.2);
        }
        
        .input-group-text {
            background: transparent;
            border: 2px solid var(--light-grey);
            border-radius: 10px 0 0 10px;
            color: var(--gold-accent);
        }
        
        .btn-login {
            background: var(--primary-dark);
            color: var(--soft-white);
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            width: 100%;
            transition: all 0.3s;
        }
        
        .btn-login:hover {
            background: var(--gold-accent);
            color: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(201,165,59,0.3);
        }
        
        .forgot-link {
            color: var(--gold-accent);
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.3s;
        }
        
        .forgot-link:hover {
            text-decoration: underline;
        }
        
        .back-link {
            text-align: center;
            margin-top: 20px;
        }
        
        .back-link a {
            color: var(--soft-white);
            text-decoration: none;
            opacity: 0.8;
            transition: all 0.3s;
        }
        
        .back-link a:hover {
            opacity: 1;
            color: var(--gold-accent);
        }
        
        .alert {
            border-radius: 10px;
            border-left: 4px solid;
        }
        
        .form-check-input:checked {
            background-color: var(--gold-accent);
            border-color: var(--gold-accent);
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="logo">
                <img src="{{ asset('logo-white.png') }}" alt="Oweru">
                <h3>Oweru<span>.</span></h3>
                <p>Admin Panel Login</p>
            </div>
            
            @if(session('error'))
                <div class="alert alert-danger mb-4">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                </div>
            @endif
            
            @if($errors->any())
                <div class="alert alert-danger mb-4">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ $errors->first() }}
                </div>
            @endif
            
            <form method="POST" action="{{ route('admin.login') }}">
                @csrf
                
                <div class="mb-4">
                    <label class="form-label">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
                    </div>
                </div>
                
                <div class="mb-4">
                    <label class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                </div>
                
                <div class="mb-4 d-flex justify-content-between align-items-center">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="remember" id="remember">
                        <label class="form-check-label" for="remember">Remember Me</label>
                    </div>
                    
                    <a href="{{ route('admin.password.request') }}" class="forgot-link">
                        <i class="fas fa-key me-1"></i>Forgot Password?
                    </a>
                </div>
                
                <button type="submit" class="btn-login">
                    <i class="fas fa-sign-in-alt me-2"></i>Login to Admin Panel
                </button>
            </form>
        </div>
        
        <div class="back-link">
            <a href="{{ route('home') }}">
                <i class="fas fa-arrow-left me-2"></i>Back to Website
            </a>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>