@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4" data-aos="fade-down">
    <h2 class="gradient-text fw-bold">
        <i class="fas fa-briefcase me-2 icon-bounce"></i>Oportunidades Incríveis
    </h2>
    <div class="pulse-animation">
        <span class="badge badge-primary fs-6">
            <i class="fas fa-fire me-1"></i>{{ $jobs->total() ?? 0 }} Vagas Ativas
        </span>
    </div>
</div>

@if($jobs->count() > 0)
    <div class="row">
        @foreach($jobs as $job)
            <div class="col-md-6 col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                <div class="card h-100">
                    <div class="card-body position-relative">
                        <div class="position-absolute top-0 end-0 m-3">
                            <span class="badge badge-success pulse-animation">
                                <i class="fas fa-star me-1"></i>Nova
                            </span>
                        </div>
                        
                        <div class="mb-3">
                            <div class="d-flex align-items-center mb-2">
                                <div class="rounded-circle d-flex align-items-center justify-content-center me-3" 
                                     style="width: 50px; height: 50px; background: var(--primary);">
                                    <i class="fas fa-building text-white"></i>
                                </div>
                                <div>
                                    <h5 class="card-title gradient-text mb-0">{{ $job->title }}</h5>
                                    <h6 class="text-muted mb-0">{{ $job->company->name ?? 'Empresa' }}</h6>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <small class="text-muted d-flex align-items-center">
                                <i class="fas fa-map-marker-alt me-2 text-primary"></i>
                                {{ $job->location ?? 'Remoto' }}
                                @if($job->is_remote)
                                    <span class="badge badge-success ms-2">
                                        <i class="fas fa-wifi me-1"></i>Remoto
                                    </span>
                                @endif
                            </small>
                        </div>

                        <p class="card-text text-muted">{{ Str::limit($job->description, 120) }}</p>

                        <div class="mb-3">
                            <span class="badge badge-primary me-2">
                                <i class="fas fa-clock me-1"></i>{{ ucfirst($job->type) }}
                            </span>
                            <span class="badge" style="background: var(--secondary);">
                                <i class="fas fa-layer-group me-1"></i>{{ ucfirst($job->level) }}
                            </span>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                <i class="fas fa-calendar me-1"></i>{{ $job->created_at->diffForHumans() }}
                            </small>
                            <a href="{{ route('jobs.show', $job) }}" class="btn btn-outline-primary btn-sm icon-bounce">
                                <i class="fas fa-eye me-1"></i>Ver Detalhes
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{ $jobs->links() }}
@else
    <div class="card" data-aos="fade-up">
        <div class="card-body text-center py-5">
            <div class="floating-animation">
                <i class="fas fa-search fa-4x gradient-text mb-4"></i>
            </div>
            <h5 class="gradient-text fw-bold">Nenhuma vaga encontrada</h5>
            <p class="text-muted">Novas oportunidades incríveis serão publicadas em breve!</p>
            <button class="btn btn-primary pulse-animation">
                <i class="fas fa-bell me-2"></i>Notificar quando houver vagas
            </button>
        </div>
    </div>
@endif
@endsection