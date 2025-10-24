@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card" data-aos="fade-up">
            <div class="card-body">
                <div class="d-flex align-items-start mb-4">
                    <div class="rounded-circle d-flex align-items-center justify-content-center me-4" 
                         style="width: 80px; height: 80px; background: var(--primary);">
                        <i class="fas fa-building text-white fa-2x"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h1 class="h3 gradient-text fw-bold mb-2">{{ $job->title }}</h1>
                        <h5 class="text-muted mb-2">
                            <a href="{{ route('companies.show', $job->company) }}" class="text-decoration-none">
                                {{ $job->company->name }}
                            </a>
                        </h5>
                        <div class="text-muted">
                            <i class="fas fa-map-marker-alt me-1 text-primary"></i>{{ $job->location }}
                            @if($job->is_remote)
                                <span class="badge badge-success ms-2">
                                    <i class="fas fa-wifi me-1"></i>Remoto
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <span class="badge badge-primary me-2">
                        <i class="fas fa-clock me-1"></i>{{ ucfirst($job->type) }}
                    </span>
                    <span class="badge" style="background: var(--secondary);">
                        <i class="fas fa-layer-group me-1"></i>{{ ucfirst($job->level) }}
                    </span>
                    @if($job->salary_min && $job->salary_max)
                        <span class="badge badge-success ms-2">
                            <i class="fas fa-dollar-sign me-1"></i>R$ {{ number_format($job->salary_min, 0, ',', '.') }} - R$ {{ number_format($job->salary_max, 0, ',', '.') }}
                        </span>
                    @endif
                </div>

                <div class="mb-4" data-aos="fade-up" data-aos-delay="100">
                    <h5 class="gradient-text fw-bold">
                        <i class="fas fa-info-circle me-2"></i>Descrição da Vaga
                    </h5>
                    <div class="text-muted">{{ nl2br(e($job->description)) }}</div>
                </div>

                @if($job->requirements)
                    <div class="mb-4" data-aos="fade-up" data-aos-delay="200">
                        <h5 class="gradient-text fw-bold">
                            <i class="fas fa-list-check me-2"></i>Requisitos
                        </h5>
                        <div class="text-muted">{{ nl2br(e($job->requirements)) }}</div>
                    </div>
                @endif

                @if($job->benefits)
                    <div class="mb-4" data-aos="fade-up" data-aos-delay="300">
                        <h5 class="gradient-text fw-bold">
                            <i class="fas fa-gift me-2"></i>Benefícios
                        </h5>
                        <div class="text-muted">{{ nl2br(e($job->benefits)) }}</div>
                    </div>
                @endif

                <div class="border-top pt-3">
                    <small class="text-muted">
                        <i class="fas fa-clock me-1"></i>Publicado {{ $job->created_at->diffForHumans() }}
                    </small>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        @auth
            <div class="card mb-4" data-aos="fade-left">
                <div class="card-body text-center">
                    <h6 class="gradient-text fw-bold mb-3">Interessado nesta vaga?</h6>
                    @if($job->hasAppliedBy(auth()->id()))
                        <button class="btn btn-success btn-lg w-100 mb-3" disabled>
                            <i class="fas fa-check me-2"></i>Já Candidatado
                        </button>
                        <small class="text-muted">Você já se candidatou para esta vaga!</small>
                    @else
                        <form action="{{ route('jobs.apply', $job) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary btn-lg w-100 pulse-animation mb-3">
                                <i class="fas fa-paper-plane me-2"></i>Candidatar-se
                            </button>
                        </form>
                        <small class="text-muted">Candidate-se agora e não perca esta oportunidade!</small>
                    @endif
                </div>
            </div>
        @else
            <div class="card mb-4" data-aos="fade-left">
                <div class="card-body text-center">
                    <h6 class="gradient-text fw-bold">Interessado nesta vaga?</h6>
                    <p class="text-muted small">Faça login para se candidatar</p>
                    <a href="{{ route('login') }}" class="btn btn-primary w-100">
                        <i class="fas fa-sign-in-alt me-2"></i>Entrar
                    </a>
                </div>
            </div>
        @endauth

        <div class="card" data-aos="fade-left" data-aos-delay="100">
            <div class="card-header" style="background: var(--primary); color: white; border-radius: 20px 20px 0 0;">
                <h6 class="mb-0"><i class="fas fa-building me-2"></i>Sobre a Empresa</h6>
            </div>
            <div class="card-body">
                <div class="text-center mb-3">
                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-2" 
                         style="width: 60px; height: 60px; background: var(--primary);">
                        <i class="fas fa-building text-white"></i>
                    </div>
                    <h6 class="gradient-text fw-bold">{{ $job->company->name }}</h6>
                </div>

                @if($job->company->description)
                    <p class="small text-muted">{{ Str::limit($job->company->description, 150) }}</p>
                @endif

                <div class="small text-muted mb-3">
                    @if($job->company->industry)
                        <div><i class="fas fa-industry me-2 text-primary"></i>{{ $job->company->industry }}</div>
                    @endif
                    @if($job->company->size)
                        <div><i class="fas fa-users me-2 text-primary"></i>{{ $job->company->size }}</div>
                    @endif
                    @if($job->company->location)
                        <div><i class="fas fa-map-marker-alt me-2 text-primary"></i>{{ $job->company->location }}</div>
                    @endif
                    @if($job->company->website)
                        <div><i class="fas fa-globe me-2 text-primary"></i><a href="{{ $job->company->website }}" target="_blank" class="text-decoration-none">Website</a></div>
                    @endif
                </div>

                <a href="{{ route('companies.show', $job->company) }}" class="btn btn-outline-primary w-100">
                    <i class="fas fa-eye me-2"></i>Ver Perfil da Empresa
                </a>
            </div>
        </div>
    </div>
</div>
@endsection