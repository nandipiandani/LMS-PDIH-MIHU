@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center mt-4">
        <div class="col-md-6">
            <!-- Card dengan tema kuning -->
            <div class="card shadow-lg border-0" style="border-radius: 15px; overflow: hidden;">
                <!-- Header dengan gradient kuning -->
                <div class="card-header text-center py-3" style="background: linear-gradient(135deg, #c00000 0%, #ffd900 100%);">
                    <h4 class="mb-0 text-white fw-bold">
                        <i class="bi bi-book me-2"></i>{{ config('app.name', 'LMS PDIH MIHU') }}
                    </h4>
                    <p class="mb-0 text-white opacity-75 mt-1">Sistem Manajemen Akademik</p>
                </div>

                <div class="card-body p-4">
                    <!-- Logo/Icon di atas form -->
                    <div class="text-center mb-4">
                         <div class="d-inline-block mb-2" style="width: 80px; height: 80px; overflow: hidden; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                            <!-- Pilih salah satu logo dari favicon.io -->
                            <img src="{{ asset('favicon_io/logo-mihu-unsur-512x512.png') }}" 
                                 alt="Logo {{ config('app.name') }}" 
                                 class="img-fluid w-100 h-100" 
                                 style="object-fit: cover;">
                        </div>
                        <h5 class="text-dark fw-semibold">{{ __('Masuk ke Akun Anda') }}</h5>
                    </div>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email Input dengan styling baru -->
                        <div class="mb-3 row">
                            <label for="email" class="col-md-4 col-form-label text-md-end fw-semibold">
                                <i class="bi bi-envelope me-1 text-warning"></i>{{ __('Alamat Email') }}
                            </label>

                            <div class="col-md-8">
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-at text-warning"></i>
                                    </span>
                                    <input id="email" type="email" class="form-control border-start-0 @error('email') is-invalid @enderror" 
                                           name="email" value="{{ old('email') }}" required autocomplete="email" autofocus 
                                           placeholder="contoh@email.com" style="border-radius: 0 0.375rem 0.375rem 0;">
                                </div>

                                @error('email')
                                    <div class="text-danger small mt-2">
                                        <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Password Input dengan toggle -->
                        <div class="mb-3 row">
                            <label for="password" class="col-md-4 col-form-label text-md-end fw-semibold">
                                <i class="bi bi-key me-1 text-warning"></i>{{ __('Kata Sandi') }}
                            </label>

                            <div class="col-md-8">
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-lock text-warning"></i>
                                    </span>
                                    <input id="password" type="password" class="form-control border-start-0 @error('password') is-invalid @enderror" 
                                           name="password" required autocomplete="current-password" 
                                           placeholder="Masukkan kata sandi" style="border-radius: 0;">
                                    <button class="btn btn-outline-warning border-start-0" type="button" id="togglePassword" style="border-radius: 0 0.375rem 0.375rem 0;">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>

                                @error('password')
                                    <div class="text-danger small mt-2">
                                        <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Remember Me Checkbox -->
                        <div class="mb-3 row">
                            <div class="col-md-8 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label fw-medium" for="remember">
                                        <i class="bi bi-check2-square me-1 text-warning"></i>{{ __('Ingat Saya') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Login Button -->
                        <div class="mb-3 row">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-warning btn-lg fw-bold text-white shadow-sm w-100 py-2" 
                                        style="background: linear-gradient(135deg, #c00000 0%, #ffd900 100%); border: none;">
                                    <i class="bi bi-box-arrow-in-right me-2"></i>{{ __('MASUK') }}
                                </button>
                            </div>
                        </div>

                        <!-- Forgot Password Link -->
                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link text-warning fw-semibold text-decoration-none p-0" 
                                       href="{{ route('password.request') }}">
                                        <i class="bi bi-question-circle me-1"></i>{{ __('Lupa Kata Sandi?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>

                        <a href="{{ url('/') }}" class="text-decoration-none text-dark small">
                            <i class="bi bi-arrow-left me-1"></i> Kembali ke Beranda
                        </a>
                    </div>
                </div>

                <!-- Footer Card -->
                <div class="card-footer text-center py-3" style="background-color: #FFF8E1;">
                    <small class="text-muted">
                        <i class="bi bi-shield-check text-warning me-1"></i>
                        Sistem terlindungi - © 2025 {{ config('app.name') }}
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript untuk toggle password -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');
    
    if (togglePassword && password) {
        togglePassword.addEventListener('click', function() {
            // Toggle type attribute
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            
            // Toggle icon
            this.innerHTML = type === 'password' ? 
                '<i class="bi bi-eye"></i>' : 
                '<i class="bi bi-eye-slash"></i>';
        });
    }
    
    // Efek focus pada input
    const inputs = document.querySelectorAll('.form-control');
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.style.borderColor = '#FFC107';
            this.style.boxShadow = '0 0 0 0.25rem rgba(255, 193, 7, 0.25)';
        });
        input.addEventListener('blur', function() {
            this.style.borderColor = '#ced4da';
            this.style.boxShadow = 'none';
        });
    });
});
</script>

<!-- Custom CSS untuk tema kuning -->
<style>
/* Warna utama */
.text-warning {
    color: #ff0707ff !important;
}
.bg-warning {
    background-color: #FFC107 !important;
}
.btn-warning {
    transition: all 0.3s ease;
}
.btn-warning:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(255, 152, 0, 0.3) !important;
}

/* Input styling */
.input-group-text {
    background-color: #FFF8E1 !important;
    border-color: #FFE082 !important;
}

/* Card styling */
.shadow-lg {
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1) !important;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .col-md-4.text-md-end {
        text-align: left !important;
        margin-bottom: 0.5rem;
    }
    .col-md-8 {
        width: 100%;
    }
    .offset-md-4 {
        margin-left: 0;
    }
}
</style>
@endsection