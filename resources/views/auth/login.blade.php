<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Oweru Real Estate Marketplace</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@300;400;500;600;700;800&family=Nunito:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <style>
        /* Brand Colors - Oweru Standard */
        :root {
            --primary-dark: #0F172A;
            --soft-white: #F8F8F9;
            --gold-accent: #C9A53B;
            --light-grey: #E5E5E5;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Raleway', sans-serif;
            background: linear-gradient(135deg, var(--primary-dark) 0%, #1e293b 50%, var(--light-grey) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-dark);
            padding: 20px;
        }
        
        h1, h2, h3 {
            font-family: 'Nunito', sans-serif;
            font-weight: 700;
        }
        
        .login-card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(15, 23, 42, 0.3);
            overflow: hidden;
            max-width: 450px;
            width: 100%;
        }
        
        .login-header {
            background: linear-gradient(135deg, var(--primary-dark) 0%, #1e293b 100%);
            color: var(--soft-white);
            padding: 40px 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .login-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200px;
            height: 200px;
            background: rgba(201, 165, 59, 0.1);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }
        
        .login-header h1 {
            font-size: 2.2rem;
            margin: 0 0 10px 0;
            font-weight: 800;
            position: relative;
            z-index: 1;
        }
        
        .login-header .gold-text {
            color: var(--gold-accent) !important;
        }
        
        .login-header p {
            margin: 0;
            opacity: 0.9;
            position: relative;
            z-index: 1;
        }
        
        .login-body {
            padding: 40px;
            background: var(--soft-white);
        }
        
        .form-control, .input-group-text {
            border-radius: 15px;
            padding: 15px 20px;
            border: 2px solid var(--light-grey);
            transition: all 0.3s;
            font-family: 'Raleway', sans-serif;
            font-size: 1rem;
        }
        
        .form-control:focus {
            border-color: var(--gold-accent);
            box-shadow: 0 0 0 4px rgba(201, 165, 59, 0.15);
        }
        
        .input-group-text {
            background: var(--light-grey);
            border-color: var(--light-grey);
            color: var(--primary-dark);
        }
        
        .btn-login {
            background: linear-gradient(135deg, var(--gold-accent) 0%, #d4b567 100%);
            border: none;
            border-radius: 15px;
            padding: 15px;
            font-weight: 600;
            color: var(--primary-dark);
            width: 100%;
            font-family: 'Raleway', sans-serif;
            font-size: 1.1rem;
            transition: all 0.3s;
            box-shadow: 0 5px 15px rgba(201, 165, 59, 0.3);
        }
        
        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(201, 165, 59, 0.4);
            color: var(--primary-dark);
        }
        
        .forgot-link {
            color: var(--gold-accent);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.9rem;
            transition: all 0.3s;
        }
        
        .forgot-link:hover {
            text-decoration: underline;
            color: var(--gold-accent);
        }
        
        .register-link {
            color: var(--gold-accent);
            text-decoration: none;
            font-weight: 600;
            font-family: 'Raleway', sans-serif;
        }
        
        .register-link:hover {
            text-decoration: underline;
        }
        
        .back-home {
            display: inline-block;
            margin-top: 20px;
            color: var(--gold-accent);
            text-decoration: none;
            font-weight: 600;
            font-family: 'Raleway', sans-serif;
            transition: all 0.3s;
        }
        
        .back-home:hover {
            transform: translateX(-5px);
            text-decoration: none;
            color: var(--gold-accent);
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        @media (max-width: 768px) {
            .login-header {
                padding: 30px 20px;
            }
            .login-header h1 {
                font-size: 1.8rem;
            }
            .login-body {
                padding: 30px 20px;
            }
        }
        
        /* Custom checkbox styling */
        .form-check-input:checked {
            background-color: var(--gold-accent);
            border-color: var(--gold-accent);
        }
        
        .form-check-input:focus {
            border-color: var(--gold-accent);
            box-shadow: 0 0 0 0.2rem rgba(201, 165, 59, 0.25);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card login-card">
                    <div class="login-header">
                        <i class="fas fa-building fa-3x mb-4" style="color: var(--gold-accent); position: relative; z-index: 1;"></i>
                        <h1>Welcome to <span class="gold-text">Oweru</span></h1>
                        <p class="mb-0">Login to Real Estate Marketplace</p>
                    </div>
                    
                    <div class="login-body">
                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif
                        
                        @if(session('status'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i>{{ session('status') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif
                        
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            
                            <div class="mb-4">
                                <label for="email" class="form-label fw-semibold">Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           id="email" name="email" value="{{ old('email') }}" required autofocus>
                                </div>
                                @error('email')
                                    <span class="text-danger small d-block mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="mb-4">
                                <label for="password" class="form-label fw-semibold">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                           id="password" name="password" required>
                                    <button type="button" class="btn btn-outline-secondary" id="togglePassword" style="border-radius: 0 15px 15px 0;">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <span class="text-danger small d-block mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="mb-4 d-flex justify-content-between align-items-center">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                    <label class="form-check-label" for="remember">
                                        Remember Me
                                    </label>
                                </div>
                                
                                <a href="{{ route('password.request') }}" class="forgot-link">
                                    <i class="fas fa-key me-1"></i>Forgot Password?
                                </a>
                            </div>
                            
                            <button type="submit" class="btn btn-login mb-4">
                                <i class="fas fa-sign-in-alt me-2"></i>Login to Oweru
                            </button>
                            
                            <div class="text-center">
                                <p class="mb-0">Don't have an account? 
                                    <a href="{{ route('register') }}" class="register-link">Register here</a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
                
                <div class="text-center mt-4">
                    <a href="/" class="back-home">
                        <i class="fas fa-arrow-left me-2"></i>Back to Oweru Home
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Toggle password visibility
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');
        
        if (togglePassword && password) {
            togglePassword.addEventListener('click', function() {
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                this.querySelector('i').classList.toggle('fa-eye');
                this.querySelector('i').classList.toggle('fa-eye-slash');
            });
        }
    </script>
</body>
</html>