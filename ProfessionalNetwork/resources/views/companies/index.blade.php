@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4" data-aos="fade-down">
    <h2 class="gradient-text fw-bold">
        <i class="fas fa-building me-2 icon-bounce"></i>Empresas Parceiras
    </h2>
    <div class="pulse-animation">
        <span class="badge" style="background: var(--secondary); font-size: 1rem;">
            <i class="fas fa-crown me-1"></i>{{ $companies->total() ?? 0 }} Empresas
        </span>
    </div>
</div>

@if($companies->count() > 0)
    <div class="row">
        @foreach($companies as $company)
            <div class="col-md-6 col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                <div class="card h-100">
                    <div class="card-body text-center position-relative">
                        <div class="position-absolute top-0 end-0 m-3">
                            <span class="badge" style="background: var(--success);">
                                <i class="fas fa-verified me-1"></i>Verificada
                            </span>
                        </div>
                        
                        <div class="floating-animation mb-3">
                            <div class="rounded-circle d-inline-flex align-items-center justify-content-center pulse-animation" 
                                 style="width: 80px; height: 80px; background: var(--primary);">
                                <i class="fas fa-building text-white fa-2x"></i>
                            </div>
                        </div>
                        
                        <h5 class="card-title gradient-text fw-bold">{{ $company->name }}</h5>
                        
                        @if($company->industry)
                            <div class="mb-2">
                                <span class="badge badge-primary">
                                    <i class="fas fa-industry me-1"></i>{{ $company->industry }}
                                </span>
                            </div>
                        @endif
                        
                        @if($company->description)
                            <p class="card-text text-muted">{{ Str::limit($company->description, 100) }}</p>
                        @endif
                        
                        <div class="mb-3">
                            @if($company->location)
                                <small class="text-muted d-flex align-items-center justify-content-center">
                                    <i class="fas fa-map-marker-alt me-2 text-primary"></i>
                                    {{ $company->location }}
                                </small>
                            @endif
                        </div>
                        
                        <div class="d-flex gap-2 justify-content-center">
                            <a href="{{ route('companies.show', $company) }}" class="btn btn-outline-primary btn-sm icon-bounce">
                                <i class="fas fa-eye me-1"></i>Ver Perfil
                            </a>
                            @auth
                                <form action="{{ route('companies.follow', $company) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        <i class="fas fa-heart me-1"></i>Seguir
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-sign-in-alt me-1"></i>Login
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{ $companies->links() }}
@else
    <div class="card" data-aos="fade-up">
        <div class="card-body text-center py-5">
            <div class="floating-animation">
                <i class="fas fa-rocket fa-4x gradient-text mb-4"></i>
            </div>
            <h5 class="gradient-text fw-bold">Seja a Primeira Empresa!</h5>
            <p class="text-muted">Cadastre sua empresa e encontre os melhores talentos</p>
            <a href="{{ route('companies.create') }}" class="btn btn-primary btn-lg pulse-animation">
                <i class="fas fa-plus me-2"></i>Cadastrar Empresa
            </a>
        </div>
    </div>
@endif
@endsection