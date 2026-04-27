<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sign In - Oweru BuildConnect</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: #F5F7FA;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }
        
        .login-card {
            max-width: 440px;
            width: 100%;
            background: #FFFFFF;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            padding: 40px 32px;
        }
        
        .logo {
            text-align: center;
            margin-bottom: 32px;
        }
        
        .logo-icon {
            width: 48px;
            height: 48px;
            background: #1E2A3A;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 12px;
        }
        
        .logo-icon i {
            font-size: 24px;
            color: #F5A623;
        }
        
        .logo h1 {
            font-size: 24px;
            font-weight: 700;
            color: #1E2A3A;
            margin: 0;
        }
        
        .logo span {
            color: #F5A623;
        }
        
        .logo p {
            font-size: 14px;
            color: #6B7280;
            margin-top: 4px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-label {
            font-size: 13px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 6px;
            display: block;
        }
        
        .form-control {
            width: 100%;
            padding: 10px 14px;
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            border: 1px solid #D1D5DB;
            border-radius: 8px;
            transition: all 0.2s;
            background: #FFFFFF;
        }
        
        .form-control:focus {
            outline: none;
            border-color: #1E2A3A;
            box-shadow: 0 0 0 3px rgba(30,42,58,0.1);
        }
        
        .input-group {
            position: relative;
        }
        
        .input-group .form-control {
            padding-right: 40px;
        }
        
        .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #9CA3AF;
            cursor: pointer;
            font-size: 14px;
        }
        
        .toggle-password:hover {
            color: #6B7280;
        }
        
        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }
        
        .checkbox {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .checkbox input {
            width: 16px;
            height: 16px;
            margin: 0;
            cursor: pointer;
        }
        
        .checkbox label {
            font-size: 13px;
            color: #6B7280;
            margin: 0;
            cursor: pointer;
        }
        
        .forgot-link {
            font-size: 13px;
            color: #1E2A3A;
            text-decoration: none;
            font-weight: 500;
        }
        
        .forgot-link:hover {
            text-decoration: underline;
        }
        
        .btn-signin {
            width: 100%;
            padding: 10px 16px;
            background: #1E2A3A;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
            margin-bottom: 24px;
        }
        
        .btn-signin:hover {
            background: #2D3A4E;
        }
        
        .divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
        }
        
        .divider-line {
            flex: 1;
            height: 1px;
            background: #E5E7EB;
        }
        
        .divider-text {
            font-size: 12px;
            color: #9CA3AF;
        }
        
        .social-buttons {
            display: flex;
            gap: 12px;
            margin-bottom: 24px;
        }
        
        .social-btn {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 8px 12px;
            background: white;
            border: 1px solid #E5E7EB;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 500;
            color: #4B5563;
            text-decoration: none;
            transition: all 0.2s;
        }
        
        .social-btn:hover {
            background: #F9FAFB;
            border-color: #D1D5DB;
        }
        
        .social-btn i {
            font-size: 16px;
        }
        
        .register-link {
            text-align: center;
            font-size: 13px;
            color: #6B7280;
        }
        
        .register-link a {
            color: #1E2A3A;
            text-decoration: none;
            font-weight: 600;
        }
        
        .register-link a:hover {
            text-decoration: underline;
        }
        
        .alert {
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .alert-danger {
            background: #FEF2F2;
            color: #DC2626;
            border-left: 3px solid #DC2626;
        }
        
        .alert-success {
            background: #ECFDF5;
            color: #059669;
            border-left: 3px solid #059669;
        }
        
        .btn-close {
            margin-left: auto;
            background: none;
            border: none;
            font-size: 14px;
            cursor: pointer;
            opacity: 0.5;
        }
        
        .back-home {
            text-align: center;
            margin-top: 24px;
        }
        
        .back-home a {
            font-size: 13px;
            color: #9CA3AF;
            text-decoration: none;
        }
        
        .back-home a:hover {
            color: #6B7280;
        }
        
        @media (max-width: 480px) {
            .login-card {
                padding: 32px 24px;
            }
            
            .social-buttons {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="logo">
            <div class="logo-icon">
                <i class="fas fa-building"></i>
            </div>
            <h1>oweru<span>build</span></h1>
            <p>Sign in to your account</p>
        </div>
        
        @if(session('error'))
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                {{ session('error') }}
                <button class="btn-close" onclick="this.parentElement.remove()">&times;</button>
            </div>
        @endif
        
        @if(session('status'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                {{ session('status') }}
                <button class="btn-close" onclick="this.parentElement.remove()">&times;</button>
            </div>
        @endif
        
        <form method="POST" action="{{ route('login') }}">
            @csrf
            
            <div class="form-group">
                <label class="form-label">Email address</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                       value="{{ old('email') }}" placeholder="name@company.com" required autofocus>
                @error('email')
                    <small style="color: #DC2626; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</small>
                @enderror
            </div>
            
            <div class="form-group">
                <label class="form-label">Password</label>
                <div class="input-group">
                    <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" 
                           placeholder="Enter your password" required>
                    <button type="button" class="toggle-password" id="togglePassword">
                        <i class="far fa-eye"></i>
                    </button>
                </div>
                @error('password')
                    <small style="color: #DC2626; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</small>
                @enderror
            </div>
            
            <div class="form-options">
                <div class="checkbox">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">Remember me</label>
                </div>
                <a href="{{ route('password.request') }}" class="forgot-link">Forgot password?</a>
            </div>
            
            <button type="submit" class="btn-signin">Sign in</button>
        </form>
        
        <div class="divider">
            <div class="divider-line"></div>
            <span class="divider-text">OR</span>
            <div class="divider-line"></div>
        </div>
        
        <div class="social-buttons">
            <a href="#" class="social-btn">
                <i class="fab fa-google"></i> Google
            </a>
            <a href="#" class="social-btn">
                <i class="fab fa-linkedin-in"></i> LinkedIn
            </a>
        </div>
        
        <div class="register-link">
            New to Oweru? <a href="{{ route('register') }}">Create an account</a>
        </div>
        
        <div class="back-home">
            <a href="/"><i class="fas fa-arrow-left"></i> Back to home</a>
        </div>
    </div>
    
    <script>
        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('password');
        
        if (togglePassword && password) {
            togglePassword.addEventListener('click', function() {
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                this.querySelector('i').classList.toggle('fa-eye');
                this.querySelector('i').classList.toggle('fa-eye-slash');
            });
        }
        
        setTimeout(function() {
            document.querySelectorAll('.alert').forEach(function(alert) {
                alert.style.opacity = '0';
                setTimeout(function() {
                    alert.remove();
                }, 300);
            });
        }, 5000);
    </script>
</body>
</html>