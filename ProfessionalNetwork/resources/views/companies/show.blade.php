@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card mb-4" data-aos="fade-up">
            <div class="card-header" style="background: var(--primary); color: white; border-radius: 20px 20px 0 0;">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle d-flex align-items-center justify-content-center me-3" 
                         style="width: 60px; height: 60px; background: rgba(255,255,255,0.2);">
                        <i class="fas fa-building text-white fa-2x"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h3 class="mb-1">{{ $company->name }}</h3>
                        @if($company->industry)
                            <p class="mb-0 opacity-75">{{ $company->industry }}</p>
                        @endif
                    </div>
                    @auth
                        <form action="{{ route('companies.follow', $company) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn {{ $isFollowing ? 'btn-light' : 'btn-outline-light' }}">
                                <i class="fas fa-{{ $isFollowing ? 'check' : 'plus' }} me-2"></i>
                                {{ $isFollowing ? 'Seguindo' : 'Seguir' }}
                            </button>
                        </form>
                    @endauth
                </div>
            </div>
            <div class="card-body">
                @if($company->description)
                    <div class="mb-4">
                        <h5 class="gradient-text fw-bold">
                            <i class="fas fa-info-circle me-2"></i>Sobre a Empresa
                        </h5>
                        <p class="text-muted">{{ $company->description }}</p>
                    </div>
                @endif

                <div class="row mb-4">
                    @if($company->founded_year)
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-calendar text-primary me-3"></i>
                                <div>
                                    <small class="text-muted d-block">Fundada em</small>
                                    <strong>{{ $company->founded_year }}</strong>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    @if($company->size)
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-users text-primary me-3"></i>
                                <div>
                                    <small class="text-muted d-block">Tamanho</small>
                                    <strong>{{ $company->size }}</strong>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    @if($company->location)
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-map-marker-alt text-primary me-3"></i>
                                <div>
                                    <small class="text-muted d-block">Localização</small>
                                    <strong>{{ $company->location }}</strong>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    @if($company->website)
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-globe text-primary me-3"></i>
                                <div>
                                    <small class="text-muted d-block">Website</small>
                                    <a href="{{ $company->website }}" target="_blank" class="text-decoration-none fw-bold">
                                        Visitar Site
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="card" data-aos="fade-up" data-aos-delay="200">
            <div class="card-header" style="background: var(--secondary); color: white; border-radius: 20px 20px 0 0;">
                <h5 class="mb-0">
                    <i class="fas fa-briefcase me-2"></i>Vagas Disponíveis ({{ $company->jobs->count() }})
                </h5>
            </div>
            <div class="card-body">
                @forelse($company->jobs as $job)
                    <div class="mb-3 pb-3 {{ !$loop->last ? 'border-bottom' : '' }}" data-aos="fade-up" data-aos-delay="{{ 300 + $loop->index * 100 }}">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <h6 class="gradient-text fw-bold mb-1">
                                    <a href="{{ route('jobs.show', $job) }}" class="text-decoration-none">
                                        {{ $job->title }}
                                    </a>
                                </h6>
                                <div class="mb-2">
                                    <span class="badge badge-primary me-2">{{ ucfirst($job->type) }}</span>
                                    <span class="badge" style="background: var(--secondary);">{{ ucfirst($job->level) }}</span>
                                    @if($job->is_remote)
                                        <span class="badge badge-success ms-2">Remoto</span>
                                    @endif
                                </div>
                                <small class="text-muted">
                                    <i class="fas fa-map-marker-alt me-1"></i>{{ $job->location }}
                                    <span class="ms-3">
                                        <i class="fas fa-clock me-1"></i>{{ $job->created_at->diffForHumans() }}
                                    </span>
                                </small>
                            </div>
                            <a href="{{ route('jobs.show', $job) }}" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-eye me-1"></i>Ver Vaga
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-4">
                        <i class="fas fa-briefcase fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Nenhuma vaga disponível no momento</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card" data-aos="fade-left">
            <div class="card-header" style="background: var(--success); color: white; border-radius: 20px 20px 0 0;">
                <h6 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Estatísticas</h6>
            </div>
            <div class="card-body text-center">
                <div class="row">
                    <div class="col-4">
                        <div class="h4 gradient-text mb-0">{{ $company->jobs->count() }}</div>
                        <small class="text-muted">Vagas</small>
                    </div>
                    <div class="col-4">
                        <div class="h4 gradient-text mb-0">{{ $company->followers->count() }}</div>
                        <small class="text-muted">Seguidores</small>
                    </div>
                    <div class="col-4">
                        <div class="h4 gradient-text mb-0">{{ $company->founded_year ? date('Y') - $company->founded_year : 0 }}</div>
                        <small class="text-muted">Anos</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection