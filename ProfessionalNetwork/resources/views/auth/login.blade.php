@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
        <div class="card" data-aos="zoom-in">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <div class="floating-animation">
                        <i class="fas fa-user-circle fa-4x gradient-text mb-3 icon-bounce"></i>
                    </div>
                    <h3 class="gradient-text fw-bold">Bem-vindo de Volta!</h3>
                    <p class="text-muted">Acesse sua conta profissional</p>
                </div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-4" data-aos="fade-up" data-aos-delay="100">
                        <label for="email" class="form-label fw-bold gradient-text">
                            <i class="fas fa-envelope me-2"></i>E-mail
                        </label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email') }}" required 
                               placeholder="seu@email.com">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4" data-aos="fade-up" data-aos-delay="200">
                        <label for="password" class="form-label fw-bold gradient-text">
                            <i class="fas fa-lock me-2"></i>Senha
                        </label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                               id="password" name="password" required 
                               placeholder="••••••••">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100 mb-4 pulse-animation" data-aos="fade-up" data-aos-delay="300">
                        <i class="fas fa-rocket me-2"></i>Entrar na Plataforma
                    </button>

                    <div class="text-center" data-aos="fade-up" data-aos-delay="400">
                        <p class="mb-0">Novo por aqui? 
                            <a href="{{ route('register') }}" class="text-decoration-none gradient-text fw-bold">Crie sua conta</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection