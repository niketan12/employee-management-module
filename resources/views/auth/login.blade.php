@extends('layouts.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<style>
body {
    background: radial-gradient(circle at top, rgba(255,255,255,0.12), transparent 35%),
                linear-gradient(135deg, #3b82f6 0%, #6366f1 45%, #8b5cf6 100%);
    min-height: 100vh;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.login-container {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem 1rem;
}

.login-card {
    width: 100%;
    max-width: 380px;
    background: rgba(255, 255, 255, 0.92);
    border-radius: 30px;
    box-shadow: 0 30px 80px rgba(15, 23, 42, 0.22);
    overflow: hidden;
    border: 1px solid rgba(255, 255, 255, 0.45);
}

.login-card .card-body {
    padding: 2rem 1.75rem 1.5rem;
}

.login-title {
    text-align: center;
    margin-bottom: 1.75rem;
}

.login-title h1 {
    margin: 0;
    color: #4f46e5;
    font-size: 1.85rem;
    font-weight: 700;
    letter-spacing: 0.06em;
}

.field-card {
    background: #eef2ff;
    border-radius: 999px;
    display: flex;
    align-items: center;
    padding: 0.85rem 1rem;
    margin-bottom: 1rem;
    border: 1px solid rgba(99, 102, 241, 0.18);
}

.field-card i {
    color: #6366f1;
    font-size: 1.05rem;
}

.field-card input {
    border: none;
    background: transparent;
    padding: 0.5rem 0.75rem;
    width: 100%;
    font-size: 1rem;
    color: #0f172a;
}

.field-card input:focus {
    outline: none;
    box-shadow: none;
}

.actions-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 0.75rem;
    margin-bottom: 1.5rem;
}

.actions-row .form-check-label {
    margin-left: 0.35rem;
    font-size: 0.95rem;
    color: #475569;
}

.forgot-password {
    color: #4f46e5;
    font-weight: 600;
    text-decoration: none;
    font-size: 0.95rem;
}

.forgot-password:hover {
    text-decoration: underline;
}

.btn-login {
    width: 100%;
    padding: 0.95rem 1rem;
    border-radius: 999px;
    border: none;
    background: linear-gradient(135deg, #7c3aed 0%, #22d3ee 100%);
    color: white;
    font-size: 1rem;
    font-weight: 700;
    box-shadow: 0 18px 40px rgba(124, 58, 237, 0.24);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.btn-login:hover {
    transform: translateY(-2px);
    box-shadow: 0 22px 45px rgba(124, 58, 237, 0.28);
}

.alt-action {
    margin-top: 1.25rem;
    text-align: center;
    font-size: 0.95rem;
    color: #475569;
}

.alt-action a {
    color: #7c3aed;
    font-weight: 700;
    text-decoration: none;
}

.alt-action a:hover {
    text-decoration: underline;
}

@media (max-width: 576px) {
    .login-card {
        margin: 0 0.5rem;
    }

    .login-card .card-body {
        padding: 1.75rem 1.25rem 1.25rem;
    }
}
</style>

<div class="login-container">
    <div class="card login-card">
        <div class="card-body">
            <div class="login-title">
                <h1>ADMIN LOGIN</h1>
            </div>
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="field-card">
                    <i class="bi bi-person"></i>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="Email Address" class="form-control @error('email') is-invalid @enderror">
                </div>
                @error('email')
                    <div class="text-danger mb-3">{{ $message }}</div>
                @enderror

                <div class="field-card">
                    <i class="bi bi-lock"></i>
                    <input id="password" type="password" name="password" required placeholder="Password" class="form-control @error('password') is-invalid @enderror">
                </div>
                @error('password')
                    <div class="text-danger mb-3">{{ $message }}</div>
                @enderror

                <div class="actions-row">
                    <div class="form-check d-flex align-items-center">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label" for="remember">Remember</label>
                    </div>
                    <a href="{{ route('password.request') }}" class="forgot-password">Forgot password?</a>
                </div>

                <button type="submit" class="btn btn-login">LOGIN</button>

                <div class="alt-action">
                    Don't have an account? <a href="{{ route('register') }}">Register</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
