@extends('layouts.guest')

@section('content')
<form method="POST" action="{{ route('login') }}" class="login-form">
    @csrf
    
    <!-- Email Input with Icon -->
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
               required 
               autofocus>
        @error('email')
            <div class="invalid-feedback">
                <i class="bi bi-exclamation-circle-fill"></i>
                {{ $message }}
            </div>
        @enderror
    </div>
    
    <!-- Password Input with Icon -->
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
    
    <!-- Remember Me & Forgot Password Row -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
            <label class="form-check-label" for="remember">Ingat saya</label>
        </div>
        <a href="{{ route('password.request') }}" class="text-decoration-none small">
            Lupa password?
        </a>
    </div>
    
    <!-- Login Button with Arrow Icon -->
    <button type="submit" class="btn btn-login w-100">
        <span class="spinner"></span>
        <span class="btn-text">
            Masuk <i class="bi bi-arrow-right ms-2"></i>
        </span>
    </button>
</form>
@endsection
