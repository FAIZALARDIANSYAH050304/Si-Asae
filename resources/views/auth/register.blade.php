@extends('layouts.guest')

@section('content')
<form method="POST" action="{{ route('register') }}">
    @csrf

    <!-- Name -->
    <div class="input-group">
        <span class="input-icon">
            <i class="bi bi-person-fill"></i>
        </span>
        <input type="text" 
               class="form-control @error('name') is-invalid @enderror" 
               id="name" 
               name="name" 
               value="{{ old('name') }}" 
               placeholder="Nama lengkap"
               required 
               autofocus>
        @error('name')
            <div class="invalid-feedback">
                <i class="bi bi-exclamation-circle-fill"></i>
                {{ $message }}
            </div>
        @enderror
    </div>
    
    <!-- Email Address -->
    <div class="input-group">
        <span class="input-icon">
            <i class="bi bi-envelope-fill"></i>
        </span>
        <input type="email" 
               class="form-control @error('email') is-invalid @enderror" 
               id="email" 
               name="email" 
               value="{{ old('email') }}" 
               placeholder="Email address"
               required>
        @error('email')
            <div class="invalid-feedback">
                <i class="bi bi-exclamation-circle-fill"></i>
                {{ $message }}
            </div>
        @enderror
    </div>
    
    <!-- Password -->
    <div class="input-group">
        <span class="input-icon">
            <i class="bi bi-lock-fill"></i>
        </span>
        <input type="password" 
               class="form-control @error('password') is-invalid @enderror" 
               id="password" 
               name="password" 
               placeholder="Password" 
               required>
        <div class="input-group-append">
            <button type="button" class="password-toggle" id="togglePassword" onclick="togglePassword()">
                <i class="bi bi-eye"></i>
            </button>
        </div>
        @error('password')
            <div class="invalid-feedback">
                <i class="bi bi-exclamation-circle-fill"></i>
                {{ $message }}
            </div>
        @enderror
    </div>
    
    <!-- Confirm Password -->
    <div class="input-group">
        <span class="input-icon">
            <i class="bi bi-lock-fill"></i>
        </span>
        <input type="password" 
               class="form-control @error('password_confirmation') is-invalid @enderror" 
               id="password_confirmation" 
               name="password_confirmation" 
               placeholder="Konfirmasi password" 
               required>
        <div class="input-group-append">
            <button type="button" class="password-toggle" id="togglePasswordConfirm" onclick="togglePasswordConfirm()">
                <i class="bi bi-eye"></i>
            </button>
        </div>
        @error('password_confirmation')
            <div class="invalid-feedback">
                <i class="bi bi-exclamation-circle-fill"></i>
                {{ $message }}
            </div>
        @enderror
    </div>
    
    <!-- Register Button -->
    <button type="submit" class="btn btn-login w-100">
        <span class="spinner"></span>
        <span class="btn-text">
            Daftar <i class="bi bi-person-plus ms-2"></i>
        </span>
    </button>
    
    <!-- Login Link -->
    <div class="login-footer">
        <a href="{{ route('login') }}">
            Sudah punya akun? Masuk
        </a>
    </div>
</form>

<script>
    // Password toggle functionality for password
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

    // Password toggle functionality for confirmation
    function togglePasswordConfirm() {
        const passwordInput = document.getElementById('password_confirmation');
        const toggleBtn = document.getElementById('togglePasswordConfirm');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleBtn.innerHTML = '<i class="bi bi-eye-slash"></i>';
        } else {
            passwordInput.type = 'password';
            toggleBtn.innerHTML = '<i class="bi bi-eye"></i>';
        }
    }
</script>
@endsection
