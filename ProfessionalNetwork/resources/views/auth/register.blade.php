@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
        <div class="card" data-aos="zoom-in">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <div class="floating-animation">
                        <i class="fas fa-user-plus fa-4x gradient-text mb-3 icon-bounce"></i>
                    </div>
                    <h3 class="gradient-text fw-bold">Junte-se a Nós!</h3>
                    <p class="text-muted">Crie sua conta profissional e acelere sua carreira</p>
                </div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="mb-3" data-aos="fade-up" data-aos-delay="100">
                        <label for="name" class="form-label fw-bold gradient-text">
                            <i class="fas fa-user me-2"></i>Nome Completo
                        </label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name') }}" required 
                               placeholder="Seu nome completo">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3" data-aos="fade-up" data-aos-delay="150">
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

                    <div class="mb-3" data-aos="fade-up" data-aos-delay="200">
                        <label for="password" class="form-label fw-bold gradient-text">
                            <i class="fas fa-lock me-2"></i>Senha
                        </label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                               id="password" name="password" required 
                               placeholder="Mínimo 8 caracteres">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3" data-aos="fade-up" data-aos-delay="250">
                        <label for="password_confirmation" class="form-label fw-bold gradient-text">
                            <i class="fas fa-check-circle me-2"></i>Confirmar Senha
                        </label>
                        <input type="password" class="form-control" 
                               id="password_confirmation" name="password_confirmation" required 
                               placeholder="Repita sua senha">
                    </div>

                    <div class="mb-4 form-check" data-aos="fade-up" data-aos-delay="300">
                        <input type="checkbox" class="form-check-input" id="is_company" name="is_company" value="1">
                        <label class="form-check-label fw-bold" for="is_company">
                            <i class="fas fa-building me-2 text-primary"></i>Sou uma empresa/recrutador
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 mb-4 pulse-animation" data-aos="fade-up" data-aos-delay="350">
                        <i class="fas fa-rocket me-2"></i>Criar Minha Conta
                    </button>

                    <div class="text-center" data-aos="fade-up" data-aos-delay="400">
                        <p class="mb-0">Já é membro? 
                            <a href="{{ route('login') }}" class="text-decoration-none gradient-text fw-bold">Faça login</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection