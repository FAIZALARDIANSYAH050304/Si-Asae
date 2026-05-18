<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SI-ASAE') }}</title>
    
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #a855f7 0%, #3b82f6 100%);
            --primary-hover: linear-gradient(135deg, #9333ea 0%, #2563eb 100%);
            --glass-bg: rgba(255, 255, 255, 0.08);
            --glass-border: rgba(255, 255, 255, 0.15);
            --input-bg: rgba(255, 255, 255, 0.05);
            --cyan: #00d4ff;
            --purple: #a855f7;
            --pink: #ec4899;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

/* Image Background - akan diatur melalui inline style */
        .bg-gradient {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-repeat: no-repeat;
            background-position: center center;
            background-size: cover;
            z-index: -1;
        }

/* Dark overlay untuk memastikan teks terlihat */
        .bg-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(15, 25, 45, 0.7) 0%, rgba(8, 12, 24, 0.7) 100%);
            z-index: 0;
        }

        /* Gradient accent overlay */
        .bg-accent {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at top right, rgba(168, 85, 247, 0.15) 0%, transparent 50%),
                        radial-gradient(circle at bottom left, rgba(59, 130, 246, 0.1) 0%, transparent 50%);
            z-index: 0;
        }

        /* Glassmorphism card */
        .login-card {
            background: var(--glass-bg);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border: 1px solid var(--glass-border);
            border-radius: 2.5rem;
            box-shadow: 
                0 25px 50px -12px rgba(0, 0, 0, 0.5),
                0 0 0 1px rgba(255, 255, 255, 0.05);
            overflow: hidden;
            max-width: 450px;
            width: 100%;
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-header {
            background: linear-gradient(135deg, #a855f7 0%, #3b82f6 100%);
            padding: 2.5rem 2rem;
            text-align: center;
            color: #fff;
            position: relative;
            overflow: hidden;
        }

        .login-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.2) 0%, transparent 60%);
            animation: shimmer 3s infinite;
        }

        @keyframes shimmer {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

.login-header i {
            font-size: 3.5rem;
            margin-bottom: 1rem;
            position: relative;
            z-index: 1;
            display: inline-block;
            animation: bounce 2s infinite;
        }

        /* Custom Logo Image */
        .login-header .logo-image {
            width: 80px;
            height: 80px;
            margin-bottom: 1rem;
            position: relative;
            z-index: 1;
            object-fit: contain;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        .login-header h3 {
            margin-bottom: 0.5rem;
            font-weight: 700;
            font-size: 1.75rem;
            position: relative;
            z-index: 1;
        }

        .login-header p {
            margin-bottom: 0;
            opacity: 0.9;
            font-size: 0.95rem;
            position: relative;
            z-index: 1;
        }

        .login-body {
            padding: 2rem;
        }

/* Form controls - Fixed for visibility */
        .form-control {
            border-radius: 1.5rem;
            padding: 1rem 1rem 1rem 3rem;
            border: 2px solid var(--glass-border);
            background: rgba(0, 0, 0, 0.3) !important;
            transition: all 0.3s ease;
            font-size: 1rem;
            color: #222 !important;
            caret-color: #a855f7;
        }

        /* Placeholder styling - abu-abu terlihat */
        .form-control::placeholder {
            color: #9ca3af !important;
            opacity: 1;
        }

        /* Saat mengetik - teks terlihat jelas */
        .form-control:not(:placeholder-shown) {
            color: #222 !important;
        }

        /* Focus state - tetap elegan */
        .form-control:focus {
            border-color: #a855f7;
            background: rgba(0, 0, 0, 0.4) !important;
            box-shadow: 0 0 0 4px rgba(168, 85, 247, 0.15);
            color: #222 !important;
            outline: none;
        }

        /* Autofill - browser default override */
        .form-control:-webkit-autofill,
        .form-control:-webkit-autofill:hover,
        .form-control:-webkit-autofill:focus,
        .form-control:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0 30px rgba(0, 0, 0, 0.3) inset !important;
            -webkit-text-fill-color: #222 !important;
            caret-color: #a855f7;
        }

        /* Invalid state */
        .form-control.is-invalid {
            border-color: #ef4444;
            background: rgba(239, 68, 68, 0.15) !important;
        }

        .form-control.is-invalid:focus {
            box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.15);
            color: #222 !important;
        }

/* Input group with icons */
        .input-group {
            position: relative;
            margin-bottom: 1.25rem;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            z-index: 10;
            color: #6b7280;
            transition: color 0.3s ease;
            font-size: 1.1rem;
        }

        /* Icon berubah ungu saat focus */
        .form-control:focus ~ .input-icon,
        .form-control:not(:placeholder-shown) ~ .input-icon {
            color: #a855f7;
        }

        /* Password toggle icon */
.password-toggle {
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 8px;
            color: #9ca3af;
            cursor: pointer;
            padding: 8px 12px;
            transition: all 0.3s ease;
            font-size: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 20;
            position: relative;
            pointer-events: auto;
        }

.password-toggle:hover {
            background: rgba(168, 85, 247, 0.3);
            border-color: #a855f7;
            color: #fff;
        }

.input-group-append {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            z-index: 10;
        }

        /* Custom checkbox */
        .form-check-input {
            width: 1.25rem;
            height: 1.25rem;
            border-radius: 4px;
            border: 2px solid var(--glass-border);
            background: var(--input-bg);
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .form-check-input:checked {
            background: linear-gradient(135deg, #a855f7 0%, #3b82f6 100%);
            border-color: #a855f7;
        }

        .form-check-input:focus {
            box-shadow: 0 0 0 4px rgba(168, 85, 247, 0.15);
        }

        .form-check-label {
            color: #d1d5db;
            cursor: pointer;
            user-select: none;
        }

        /* Modern button */
        .btn-login {
            background: var(--primary-gradient);
            border: none;
            border-radius: 1.5rem;
            padding: 1rem 1.5rem;
            font-weight: 600;
            font-size: 1.1rem;
            color: #fff;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s ease;
        }

        .btn-login:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 10px 40px rgba(168, 85, 247, 0.4);
        }

        .btn-login:hover::before {
            left: 100%;
        }

        .btn-login:active {
            transform: translateY(0) scale(0.98);
        }

        .btn-login:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
        }

        .btn-login .spinner {
            display: none;
            width: 20px;
            height: 20px;
            border: 2px solid transparent;
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
            margin-right: 0.5rem;
        }

        .btn-login.loading .spinner {
            display: inline-block;
        }

        .btn-login.loading .btn-text {
            opacity: 0.8;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Invalid feedback */
        .invalid-feedback {
            color: #ef4444;
            font-size: 0.85rem;
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.25rem;
            animation: shake 0.4s ease;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        /* Footer links */
        .login-footer {
            text-align: center;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--glass-border);
        }

        .login-footer a {
            color: #a855f7;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s ease;
        }

        .login-footer a:hover {
            color: #3b82f6;
            text-decoration: underline;
        }

        /* Toast notifications */
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
        }

        .toast {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(14px);
            border: 1px solid var(--glass-border);
            border-radius: 1rem;
            color: #fff;
            padding: 1rem 1.5rem;
            margin-bottom: 0.5rem;
            animation: slideInRight 0.3s ease;
        }

        .toast-success {
            border-left: 4px solid #22c55e;
        }

        .toast-error {
            border-left: 4px solid #ef4444;
        }

        .toast-info {
            border-left: 4px solid #3b82f6;
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(100%);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Social buttons */
        .social-buttons {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .btn-social {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: transparent;
            border: 2px solid var(--glass-border);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            transition: all 0.3s ease;
        }

        .btn-social:hover {
            background: var(--glass-bg);
            border-color: #a855f7;
            color: #a855f7;
            transform: translateY(-2px);
        }

        /* Responsive */
        @media (max-width: 480px) {
            .login-card {
                margin: 1rem;
                border-radius: 2rem;
            }

            .login-header {
                padding: 2rem 1.5rem;
            }

            .login-body {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Debug: Show image path -->
    <!-- Image URL: {{ asset('images/1779085812226.jpg.jpeg') }} -->
    <!-- Image Background -->
    <img src="{{ asset('images/1779085812226.jpg.jpeg') }}" alt="Background" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; z-index: -1;">
    
    <!-- Dark overlay -->
    <div class="bg-overlay"></div>
    
    <!-- Accent overlay -->
    <div class="bg-accent"></div>

<div class="login-card">
        <div class="login-header">
            @php $loginLogo = config('app.login_logo'); @endphp
            
            @if($loginLogo['type'] === 'image')
                <img src="{{ asset($loginLogo['image']) }}" alt="{{ $loginLogo['alt'] }}" class="logo-image">
            @else
                <i class="{{ $loginLogo['icon'] }}"></i>
            @endif
            
            <h3 class="mb-1">SI-ASAE</h3>
            <p class="mb-0">Sistem Informasi Asimilasi dan Edukasi</p>
        </div>
        
        <div class="login-body">
            @yield('content')
        </div>
    </div>

    <script>
        // Password toggle functionality
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleBtn = document.getElementById('togglePassword');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleBtn.innerHTML = '<i class="bi bi-eye-slash"></i>';
            } else {
                passwordInput.type = 'password';
                toggleBtn.innerHTML = '<i class="bi bi-eye"></i>';
            }
        }

        // Loading state on form submit
        document.querySelector('form').addEventListener('submit', function() {
            const btn = document.querySelector('.btn-login');
            if (btn) {
                btn.classList.add('loading');
                btn.disabled = true;
            }
        });

        // Toast notification function
        function showToast(message, type = 'info') {
            const container = document.querySelector('.toast-container') || createToastContainer();
            const toast = document.createElement('div');
            toast.className = `toast toast-${type}`;
            toast.innerHTML = `
                <i class="bi bi-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'}"></i>
                <span class="ms-2">${message}</span>
            `;
            container.appendChild(toast);
            
            setTimeout(() => {
                toast.style.animation = 'slideInRight 0.3s ease reverse';
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

        function createToastContainer() {
            const container = document.createElement('div');
            container.className = 'toast-container';
            document.body.appendChild(container);
            return container;
        }
    </script>
</body>
</html>
