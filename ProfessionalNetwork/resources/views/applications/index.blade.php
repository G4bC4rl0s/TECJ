@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4" data-aos="fade-down">
    <h2 class="gradient-text fw-bold">
        <i class="fas fa-paper-plane me-2 icon-bounce"></i>Minhas Candidaturas
    </h2>
    <div class="pulse-animation">
        <span class="badge" style="background: var(--secondary); font-size: 1rem;">
            <i class="fas fa-briefcase me-1"></i>{{ $applications->count() }} Candidaturas
        </span>
    </div>
</div>

@if($applications->isEmpty())
    <div class="card" data-aos="fade-up">
        <div class="card-body text-center py-5">
            <div class="floating-animation">
                <i class="fas fa-search fa-4x gradient-text mb-4"></i>
            </div>
            <h5 class="gradient-text fw-bold">Nenhuma candidatura ainda</h5>
            <p class="text-muted mb-4">Você ainda não se candidatou para nenhuma vaga. Que tal começar agora?</p>
            <a href="{{ route('jobs.index') }}" class="btn btn-primary btn-lg pulse-animation">
                <i class="fas fa-search me-2"></i>Explorar Vagas
            </a>
        </div>
    </div>
@else
    <div class="row">
        @foreach($applications as $application)
            <div class="col-lg-6 mb-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                <div class="card h-100">
                    <div class="card-body position-relative">
                        <div class="position-absolute top-0 end-0 m-3">
                            <span class="badge 
                                @if($application->status === 'pending') badge-warning
                                @elseif($application->status === 'accepted') badge-success
                                @else badge-danger @endif">
                                <i class="fas fa-
                                    @if($application->status === 'pending') clock
                                    @elseif($application->status === 'accepted') check
                                    @else times @endif me-1"></i>
                                @if($application->status === 'pending') Pendente
                                @elseif($application->status === 'accepted') Aceita
                                @else Rejeitada @endif
                            </span>
                        </div>
                        
                        <div class="d-flex align-items-start mb-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center me-3" 
                                 style="width: 50px; height: 50px; background: var(--primary);">
                                <i class="fas fa-building text-white"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="card-title text-dark fw-bold mb-1">
                                    {{ $application->jobListing->title }}
                                </h5>
                                <h6 class="text-muted mb-0">{{ $application->jobListing->company->name }}</h6>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <div class="row text-muted small">
                                <div class="col-6">
                                    <i class="fas fa-map-marker-alt me-2 text-primary"></i>
                                    {{ $application->jobListing->location }}
                                </div>
                                <div class="col-6">
                                    <i class="fas fa-briefcase me-2 text-primary"></i>
                                    {{ ucfirst($application->jobListing->type) }}
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <small class="text-muted">
                                <i class="fas fa-calendar me-2 text-primary"></i>
                                Candidatura: {{ $application->created_at->format('d/m/Y') }}
                                <span class="ms-2">({{ $application->created_at->diffForHumans() }})</span>
                            </small>
                        </div>
                        
                        <div class="d-flex gap-2 justify-content-between">
                            <a href="{{ route('jobs.show', $application->jobListing) }}" 
                               class="btn btn-outline-primary btn-sm flex-grow-1">
                                <i class="fas fa-eye me-1"></i>Ver Vaga
                            </a>
                            <a href="{{ route('companies.show', $application->jobListing->company) }}" 
                               class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-building me-1"></i>Empresa
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif
@endsection