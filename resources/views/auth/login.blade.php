<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HealthCare Plus | Login</title>
    <style>
        /* --- VANILLA CSS BASE --- */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; height: 100vh; overflow: hidden; }

        /* --- SPLIT LAYOUT --- */
        .login-wrapper { display: flex; height: 100vh; width: 100vw; }

        /* LEFT SIDE: BRANDING */
        .brand-section { 
            flex: 1; 
            background-color: #1a2e1a; /* Dark Green matching your sidebar */
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
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }
        
        .brand-logo-container svg { width: 80px; height: 80px; color: #27ae60; }
        .brand-section h1 { font-size: 36px; font-weight: bold; margin-bottom: 15px; }
        .brand-section p { font-size: 16px; color: #bdc3c7; line-height: 1.6; max-width: 400px; }

        /* RIGHT SIDE: FORM */
        .form-section { 
            flex: 1; 
            background-color: #f4f7f6; 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            padding: 60px; 
        }
        
        .form-container {
            background-color: white; 
            padding: 50px; 
            border-radius: 15px; 
            width: 100%; 
            max-width: 450px; 
            box-shadow: 0 15px 35px rgba(0,0,0,0.1); 
        }

        .form-container h2 { font-size: 28px; color: #333; margin-bottom: 10px; font-weight: 600; }
        .subtitle { font-size: 14px; color: #7f8c8d; margin-bottom: 30px; }

        /* INPUT STYLING */
        .input-group { margin-bottom: 20px; position: relative; }
        .input-group label { display: block; font-size: 13px; color: #555; margin-bottom: 8px; font-weight: 500; }
        
        .input-wrapper { position: relative; }
        .input-icon { position: absolute; left: 15px; top: 50%; transform: translateY(-50%); width: 18px; height: 18px; color: #95a5a6; }
        
        .form-input {
            width: 100%; 
            padding: 14px 15px 14px 45px; 
            border: 1px solid #e0e0e0; 
            border-radius: 8px; 
            font-size: 14px; 
            transition: 0.3s;
        }
        
        .form-input:focus { border-color: #27ae60; outline: none; box-shadow: 0 0 0 3px rgba(39, 174, 96, 0.1); }

        /* BUTTONS & LINKS */
        .options-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; font-size: 13px; }
        .forgot-link { color: #7f8c8d; text-decoration: none; }

        .btn-signin {
            background-color: #27ae60; 
            color: white; 
            border: none; 
            padding: 16px; 
            font-size: 15px; 
            font-weight: 600; 
            border-radius: 8px; 
            cursor: pointer; 
            width: 100%; 
            transition: 0.3s;
        }
        
        .btn-signin:hover { background-color: #219653; transform: translateY(-1px); }

        .register-footer { text-align: center; margin-top: 30px; font-size: 13px; color: #7f8c8d; }
        .register-footer a { color: #27ae60; text-decoration: none; font-weight: bold; }

        .error-msg { color: #e74c3c; font-size: 13px; margin-top: 15px; text-align: center; }
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
            <p>Secure access to our comprehensive appointment management system.</p>
        </div>

        <div class="form-section">
            <div class="form-container">
                <h2>Welcome Back</h2>
                <p class="subtitle">Sign in to access your account</p>
                
                <form action="/login" method="POST">
                    @csrf
                    
                    <div class="input-group">
                        <label>Email Address</label>
                        <div class="input-wrapper">
                            <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                            </svg>
                            <input type="email" name="email" class="form-input" placeholder="you@example.com" required value="{{ old('email') }}">
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label>Password</label>
                        <div class="input-wrapper">
                            <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                            </svg>
                            <input type="password" name="password" class="form-input" placeholder="••••••••" required>
                        </div>
                    </div>
                    
                    <div class="options-row">
                        <label style="display: flex; align-items: center; color: #555;">
                            <input type="checkbox" name="remember" style="margin-right: 8px;"> Remember me
                        </label>
                        <a href="#" class="forgot-link">Forgot password?</a>
                    </div>

                    <button type="submit" class="btn-signin">SIGN IN</button>
                </form>

                @if($errors->any())
                    <p class="error-msg">{{ $errors->first() }}</p>
                @endif

                <div class="register-footer">
    Don't have an account? <a href="{{ route('register') }}">Register here</a>
</div>
            </div>
        </div>
    </div>

</body>
</html>