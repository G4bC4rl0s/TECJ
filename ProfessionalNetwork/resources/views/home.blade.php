@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="hero-section text-center" data-aos="fade-up">
            <div class="floating-animation">
                <i class="fas fa-network-wired fa-5x text-white mb-4 icon-bounce"></i>
            </div>
            <h1 class="hero-title">Bem-vindo ao TECJ</h1>
            <p class="hero-subtitle mb-4">A plataforma profissional que conecta talentos e oportunidades com tecnologia de ponta</p>
            
            @guest
                <div class="d-flex gap-3 justify-content-center mt-4" data-aos="fade-up" data-aos-delay="200">
                    <a href="{{ route('register') }}" class="btn btn-primary btn-lg pulse-animation">
                        <i class="fas fa-rocket me-2"></i>Começar Agora
                    </a>
                    <a href="{{ route('login') }}" class="btn btn-outline-primary btn-lg">
                        <i class="fas fa-sign-in-alt me-2"></i>Entrar
                    </a>
                </div>
            @endguest
        </div>

        @auth
        <div class="card mb-4" data-aos="fade-up" data-aos-delay="300">
            <div class="card-header" style="background: var(--primary); color: white; border-radius: 20px 20px 0 0;">
                <h5 class="mb-0"><i class="fas fa-fire me-2"></i>Feed de Atividades</h5>
            </div>
            <div class="card-body">
                @forelse($posts as $post)
                    <div class="mb-3 pb-3 border-bottom" data-aos="fade-left" data-aos-delay="{{ $loop->index * 100 }}">
                        <div class="d-flex align-items-center mb-2">
                            <div class="rounded-circle d-flex align-items-center justify-content-center me-3 pulse-animation" 
                                 style="width: 50px; height: 50px; background: 
                                 @if($post->type === 'job_application') var(--success)
                                 @elseif($post->type === 'company_follow') var(--secondary)
                                 @else var(--primary) @endif;">
                                <i class="fas 
                                   @if($post->type === 'job_application') fa-briefcase
                                   @elseif($post->type === 'company_follow') fa-heart
                                   @else fa-user @endif text-white"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 gradient-text">{{ $post->user->name }}</h6>
                                <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                        <p class="mb-0">{{ $post->content }}</p>
                    </div>
                @empty
                    <div class="text-center py-4">
                        <i class="fas fa-comments fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Nenhuma atividade ainda. Comece a seguir pessoas!</p>
                    </div>
                @endforelse
            </div>
        </div>
        @endauth
    </div>

    <div class="col-lg-4">
        <div class="card mb-4" data-aos="fade-left" data-aos-delay="400">
            <div class="card-header" style="background: var(--secondary); color: white; border-radius: 20px 20px 0 0;">
                <h6 class="mb-0"><i class="fas fa-rocket me-2"></i>Oportunidades Quentes</h6>
            </div>
            <div class="card-body">
                @forelse($recentJobs as $job)
                    <div class="mb-3 pb-3 border-bottom" data-aos="zoom-in" data-aos-delay="{{ $loop->index * 150 }}">
                        <h6 class="mb-1 gradient-text">{{ $job->title }}</h6>
                        <small class="text-muted fw-bold">{{ $job->company->name ?? 'Empresa' }}</small>
                        <div class="small text-muted mt-1">
                            <i class="fas fa-map-marker-alt me-1 text-primary"></i>{{ $job->location ?? 'Remoto' }}
                            <span class="badge badge-success ms-2">Nova</span>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-3">
                        <i class="fas fa-briefcase fa-2x text-muted mb-2"></i>
                        <p class="text-muted small">Nenhuma vaga disponível</p>
                    </div>
                @endforelse
                <a href="{{ route('jobs.index') }}" class="btn btn-outline-primary w-100 mt-2">
                    <i class="fas fa-search me-2"></i>Explorar Todas
                </a>
            </div>
        </div>

        <div class="card" data-aos="fade-left" data-aos-delay="500">
            <div class="card-header" style="background: var(--success); color: white; border-radius: 20px 20px 0 0;">
                <h6 class="mb-0"><i class="fas fa-star me-2"></i>Recursos Premium</h6>
            </div>
            <div class="card-body">
                <ul class="list-unstyled">
                    <li class="mb-3" data-aos="fade-up" data-aos-delay="600">
                        <i class="fas fa-user-tie text-primary me-3 icon-bounce"></i>
                        <span class="fw-bold">Perfil Profissional</span>
                    </li>
                    <li class="mb-3" data-aos="fade-up" data-aos-delay="650">
                        <i class="fas fa-search text-primary me-3 icon-bounce"></i>
                        <span class="fw-bold">Busca Inteligente</span>
                    </li>
                    <li class="mb-3" data-aos="fade-up" data-aos-delay="700">
                        <i class="fas fa-users text-primary me-3 icon-bounce"></i>
                        <span class="fw-bold">Networking Avançado</span>
                    </li>
                    <li class="mb-3" data-aos="fade-up" data-aos-delay="750">
                        <i class="fas fa-chart-line text-primary me-3 icon-bounce"></i>
                        <span class="fw-bold">Analytics em Tempo Real</span>
                    </li>
                    <li class="mb-3" data-aos="fade-up" data-aos-delay="800">
                        <i class="fas fa-bolt text-primary me-3 icon-bounce"></i>
                        <span class="fw-bold">Notificações Instantâneas</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection