<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Create Account - Oweru BuildConnect</title>
    
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
        
        .register-card {
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
        
        .form-control, .form-select {
            width: 100%;
            padding: 10px 14px;
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            border: 1px solid #D1D5DB;
            border-radius: 8px;
            transition: all 0.2s;
            background: #FFFFFF;
        }
        
        .form-control:focus, .form-select:focus {
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
        
        .login-link {
            font-size: 13px;
            color: #1E2A3A;
            text-decoration: none;
            font-weight: 500;
        }
        
        .login-link:hover {
            text-decoration: underline;
        }
        
        .btn-register {
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
        
        .btn-register:hover {
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
        
        .login-link-bottom {
            text-align: center;
            font-size: 13px;
            color: #6B7280;
        }
        
        .login-link-bottom a {
            color: #1E2A3A;
            text-decoration: none;
            font-weight: 600;
        }
        
        .login-link-bottom a:hover {
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
        
        .file-input-wrapper {
            position: relative;
            margin-bottom: 20px;
        }
        
        .file-input {
            opacity: 0;
            position: absolute;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }
        
        .file-preview {
            border: 2px dashed #D1D5DB;
            border-radius: 8px;
            padding: 40px 20px;
            text-align: center;
            color: #9CA3AF;
            transition: all 0.2s;
            cursor: pointer;
        }
        
        .file-preview:hover {
            border-color: #1E2A3A;
            background: #F9FAFB;
        }
        
        .file-preview i {
            font-size: 24px;
            margin-bottom: 12px;
        }
        
        .file-preview.active {
            border-color: #10B981;
            background: #ECFDF5;
        }
        
        .preview-image {
            max-width: 100px;
            max-height: 100px;
            border-radius: 8px;
            margin-top: 12px;
        }
        
        @media (max-width: 480px) {
            .register-card {
                padding: 32px 24px;
            }
        }
    </style>
</head>
<body>
    <div class="register-card">
        <div class="logo">
            <div class="logo-icon">
                <i class="fas fa-user-plus"></i>
            </div>
            <h1>oweru<span>build</span></h1>
            <p>Create your professional account</p>
        </div>
        
        @if($errors->any())
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                <strong>Please check:</strong>
                <ul style="margin: 4px 0 0 20px; font-size: 12px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button class="btn-close" onclick="this.parentElement.remove()">&times;</button>
            </div>
        @endif
        
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
        
        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" id="registerForm">
            @csrf
            
            <div class="form-group">
                <label class="form-label">Full Name <span style="color: #DC2626;">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                       value="{{ old('name') }}" placeholder="John Doe" required autofocus>
                @error('name')
                    <small style="color: #DC2626; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</small>
                @enderror
            </div>
            
            <div class="form-group">
                <label class="form-label">Email Address <span style="color: #DC2626;">*</span></label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                       value="{{ old('email') }}" placeholder="john@company.com" required>
                @error('email')
                    <small style="color: #DC2626; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</small>
                @enderror
            </div>
            
            <div class="form-group">
                <label class="form-label">Phone Number <span style="color: #DC2626;">*</span></label>
                <input type="tel" name="phone" class="form-control @error('phone') is-invalid @enderror" 
                       value="{{ old('phone') }}" placeholder="+1 (555) 000-9999" required>
                @error('phone')
                    <small style="color: #DC2626; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</small>
                @enderror
            </div>
            
            <div class="form-group">
                <label class="form-label">Address <span style="color: #DC2626;">*</span></label>
                <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" 
                       value="{{ old('address') }}" placeholder="123 Main St, City" required>
                @error('address')
                    <small style="color: #DC2626; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</small>
                @enderror
            </div>
            
            <div class="form-group">
                <label class="form-label">Account Type <span style="color: #DC2626;">*</span></label>
                <select name="user_type" class="form-select @error('user_type') is-invalid @enderror" required>
                    <option value="">Choose your role</option>
                    <option value="client" {{ old('user_type') == 'client' ? 'selected' : '' }}>Client (Hire professionals)</option>
                    <option value="professional" {{ old('user_type') == 'professional' ? 'selected' : '' }}>Professional (Find work)</option>
                    <option value="store_owner" {{ old('user_type') == 'store_owner' ? 'selected' : '' }}>Store Owner (Sell products)</option>
                </select>
                @error('user_type')
                    <small style="color: #DC2626; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</small>
                @enderror
            </div>
            
            <div class="form-group">
                <label class="form-label">Profile Photo (optional)</label>
                <div class="file-input-wrapper">
                    <input type="file" name="profile_image" id="profileImage" class="file-input" accept="image/jpeg,image/png,image/webp">
                    <div class="file-preview" id="filePreview">
                        <i class="fas fa-user"></i>
                        <p>Add profile photo</p>
                        <small>JPG, PNG up to 5MB</small>
                        <div id="previewImage"></div>
                    </div>
                </div>
                @error('profile_image')
                    <small style="color: #DC2626; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</small>
                @enderror
            </div>
            
            <div class="form-group">
                <label class="form-label">Password <span style="color: #DC2626;">*</span></label>
                <div class="input-group">
                    <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" 
                           placeholder="Create strong password" required>
                    <button type="button" class="toggle-password" id="togglePassword">
                        <i class="far fa-eye"></i>
                    </button>
                </div>
                @error('password')
                    <small style="color: #DC2626; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</small>
                @enderror
            </div>
            
            <div class="form-group">
                <label class="form-label">Confirm Password <span style="color: #DC2626;">*</span></label>
                <div class="input-group">
                    <input type="password" name="password_confirmation" id="passwordConfirm" class="form-control" 
                           placeholder="Confirm password" required>
                </div>
            </div>
            
            <div class="form-options">
                <div class="checkbox">
                    <input type="checkbox" id="terms" name="terms" required>
                    <label for="terms">I agree to Terms & Privacy Policy</label>
                </div>
            </div>
            
            <button type="submit" class="btn-register" id="submitBtn">Create Account</button>
        </form>
        
        <div class="divider">
            <div class="divider-line"></div>
            <span class="divider-text">OR</span>
            <div class="divider-line"></div>
        </div>
        
        <div class="login-link-bottom">
            Have an account? <a href="{{ route('login') }}">Sign in</a>
        </div>
        
        <div class="back-home">
            <a href="/"><i class="fas fa-arrow-left"></i> Back to home</a>
        </div>
    </div>
    
    <script>
        // Password toggle
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
        
        // Profile photo preview
        const fileInput = document.getElementById('profileImage');
        const filePreview = document.getElementById('filePreview');
        const previewImage = document.getElementById('previewImage');
        
        fileInput?.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    previewImage.innerHTML = `<img src="${event.target.result}" class="preview-image" alt="Preview">`;
                    filePreview.classList.add('active');
                };
                reader.readAsDataURL(file);
            }
        });
        
        // File preview click
        filePreview?.addEventListener('click', () => fileInput.click());
        
        // Auto-hide alerts
        setTimeout(function() {
            document.querySelectorAll('.alert').forEach(function(alert) {
                alert.style.opacity = '0';
                setTimeout(function() {
                    alert.remove();
                }, 300);
            });
        }, 5000);
        
        // Form validation
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            if (!document.getElementById('terms').checked) {
                e.preventDefault();
                alert('Please agree to the Terms & Privacy Policy');
            }
        });
    </script>
</body>
</html>

