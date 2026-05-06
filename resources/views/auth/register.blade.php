<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HealthCare Plus | Register</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; height: 100vh; overflow: hidden; }

        .login-wrapper { display: flex; height: 100vh; width: 100vw; }

        /* LEFT SIDE: BRANDING */
        .brand-section { 
            flex: 1; 
            background-color: #1a2e1a; 
            color: white; 
            display: flex; 
            flex-direction: column; 
            justify-content: center; 
            align-items: center; 
            padding: 60px; 
            text-align: center; 
        }
        
        .brand-logo-container {
            background-color: white; 
            padding: 30px; 
            border-radius: 25px; 
            margin-bottom: 25px; 
        }
        
        .brand-logo-container svg { width: 80px; height: 80px; color: #27ae60; }
        .brand-section h1 { font-size: 36px; font-weight: bold; margin-bottom: 15px; }

        /* RIGHT SIDE: FORM */
        .form-section { 
            flex: 1; 
            background-color: #f4f7f6; 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            padding: 40px; 
        }
        
        .form-container {
            background-color: white; 
            padding: 40px; 
            border-radius: 15px; 
            width: 100%; 
            max-width: 450px; 
            box-shadow: 0 15px 35px rgba(0,0,0,0.1); 
            max-height: 95vh;
            overflow-y: auto;
        }

        .form-container h2 { font-size: 24px; color: #333; margin-bottom: 5px; font-weight: 600; }
        .subtitle { font-size: 13px; color: #7f8c8d; margin-bottom: 20px; }

        .input-group { margin-bottom: 15px; }
        .input-group label { display: block; font-size: 12px; color: #555; margin-bottom: 5px; font-weight: 500; }
        
        .form-input {
            width: 100%; 
            padding: 12px 15px; 
            border: 1px solid #e0e0e0; 
            border-radius: 8px; 
            font-size: 14px; 
        }
        
        .form-input:focus { border-color: #27ae60; outline: none; }

        .btn-register {
            background-color: #27ae60; 
            color: white; 
            border: none; 
            padding: 14px; 
            font-size: 15px; 
            font-weight: 600; 
            border-radius: 8px; 
            cursor: pointer; 
            width: 100%; 
            margin-top: 10px;
        }
        
        .btn-register:hover { background-color: #219653; }

        .footer-link { text-align: center; margin-top: 20px; font-size: 13px; color: #7f8c8d; }
        .footer-link a { color: #27ae60; text-decoration: none; font-weight: bold; }

        .error-msg { color: #e74c3c; font-size: 12px; margin-top: 5px; }
    </style>
</head>
<body>

    <div class="login-wrapper">
        <div class="brand-section">
            <div class="brand-logo-container">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 9l1.054-.318a4.5 4.5 0 014.185 0L15 9m-6 0c0 1.268.63 2.39 1.593 3.061M9 9V6a3 3 0 016 0v3m0 0c.963.67 1.593 1.793 1.593 3.061M12 21a9.003 9.003 0 008.367-5.557M12 21a9.003 9.003 0 01-8.367-5.557M12 21V12m0 0a4.5 4.5 0 100-9 4.5 4.5 0 000 9z" />
                </svg>
            </div>
            <h1>HealthCare Plus</h1>
            <p>Join our community for easy healthcare management.</p>
        </div>

        <div class="form-section">
            <div class="form-container">
                <h2>Create Account</h2>
                <p class="subtitle">Enter your details to get started</p>
                
                <form action="{{ route('register') }}" method="POST">
                    @csrf
                    
                    <div class="input-group">
                        <label>Full Name</label>
                        <input type="text" name="name" class="form-input" placeholder="John Doe" required value="{{ old('name') }}">
                        @error('name') <p class="error-msg">{{ $message }}</p> @enderror
                    </div>

                    <div class="input-group">
                        <label>Email Address</label>
                        <input type="email" name="email" class="form-input" placeholder="john@example.com" required value="{{ old('email') }}">
                        @error('email') <p class="error-msg">{{ $message }}</p> @enderror
                    </div>
                    
                    <div class="input-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-input" placeholder="••••••••" required>
                        @error('password') <p class="error-msg">{{ $message }}</p> @enderror
                    </div>

                    <div class="input-group">
                        <label>Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-input" placeholder="••••••••" required>
                    </div>

                    <button type="submit" class="btn-register">REGISTER NOW</button>
                </form>

                <div class="footer-link">
                    Already have an account? <a href="{{ route('login') }}">Sign In</a>
                </div>
            </div>
        </div>
    </div>

</body>
</html>