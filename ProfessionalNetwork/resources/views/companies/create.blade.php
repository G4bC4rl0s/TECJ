@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card" data-aos="zoom-in">
            <div class="card-header" style="background: var(--primary); color: white; border-radius: 20px 20px 0 0;">
                <h4 class="mb-0"><i class="fas fa-building me-2"></i>Cadastrar Empresa</h4>
            </div>
            <div class="card-body p-5">
                <form action="{{ route('companies.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-8 mb-4" data-aos="fade-up" data-aos-delay="100">
                            <label for="name" class="form-label fw-bold gradient-text">
                                <i class="fas fa-building me-2"></i>Nome da Empresa *
                            </label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" required
                                   placeholder="Digite o nome da empresa">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="150">
                            <label for="founded_year" class="form-label fw-bold gradient-text">
                                <i class="fas fa-calendar me-2"></i>Ano de Fundação
                            </label>
                            <input type="number" class="form-control @error('founded_year') is-invalid @enderror" 
                                   id="founded_year" name="founded_year" value="{{ old('founded_year') }}"
                                   min="1800" max="{{ date('Y') }}" placeholder="2020">
                            @error('founded_year')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4" data-aos="fade-up" data-aos-delay="200">
                            <label for="industry" class="form-label fw-bold gradient-text">
                                <i class="fas fa-industry me-2"></i>Setor de Atuação
                            </label>
                            <select class="form-control @error('industry') is-invalid @enderror" id="industry" name="industry">
                                <option value="">Selecione o setor</option>
                                <option value="Tecnologia" {{ old('industry') == 'Tecnologia' ? 'selected' : '' }}>Tecnologia</option>
                                <option value="Saúde" {{ old('industry') == 'Saúde' ? 'selected' : '' }}>Saúde</option>
                                <option value="Educação" {{ old('industry') == 'Educação' ? 'selected' : '' }}>Educação</option>
                                <option value="Financeiro" {{ old('industry') == 'Financeiro' ? 'selected' : '' }}>Financeiro</option>
                                <option value="Varejo" {{ old('industry') == 'Varejo' ? 'selected' : '' }}>Varejo</option>
                                <option value="Consultoria" {{ old('industry') == 'Consultoria' ? 'selected' : '' }}>Consultoria</option>
                                <option value="Marketing" {{ old('industry') == 'Marketing' ? 'selected' : '' }}>Marketing</option>
                                <option value="Outros" {{ old('industry') == 'Outros' ? 'selected' : '' }}>Outros</option>
                            </select>
                            @error('industry')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-4" data-aos="fade-up" data-aos-delay="250">
                            <label for="size" class="form-label fw-bold gradient-text">
                                <i class="fas fa-users me-2"></i>Tamanho da Empresa
                            </label>
                            <select class="form-control @error('size') is-invalid @enderror" id="size" name="size">
                                <option value="">Selecione o tamanho</option>
                                <option value="1-10 funcionários" {{ old('size') == '1-10 funcionários' ? 'selected' : '' }}>1-10 funcionários</option>
                                <option value="11-50 funcionários" {{ old('size') == '11-50 funcionários' ? 'selected' : '' }}>11-50 funcionários</option>
                                <option value="51-200 funcionários" {{ old('size') == '51-200 funcionários' ? 'selected' : '' }}>51-200 funcionários</option>
                                <option value="201-500 funcionários" {{ old('size') == '201-500 funcionários' ? 'selected' : '' }}>201-500 funcionários</option>
                                <option value="500+ funcionários" {{ old('size') == '500+ funcionários' ? 'selected' : '' }}>500+ funcionários</option>
                            </select>
                            @error('size')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4" data-aos="fade-up" data-aos-delay="300">
                            <label for="location" class="form-label fw-bold gradient-text">
                                <i class="fas fa-map-marker-alt me-2"></i>Localização
                            </label>
                            <input type="text" class="form-control @error('location') is-invalid @enderror" 
                                   id="location" name="location" value="{{ old('location') }}"
                                   placeholder="São Paulo, SP">
                            @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-4" data-aos="fade-up" data-aos-delay="350">
                            <label for="website" class="form-label fw-bold gradient-text">
                                <i class="fas fa-globe me-2"></i>Website
                            </label>
                            <input type="url" class="form-control @error('website') is-invalid @enderror" 
                                   id="website" name="website" value="{{ old('website') }}"
                                   placeholder="https://www.empresa.com">
                            @error('website')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4" data-aos="fade-up" data-aos-delay="400">
                        <label for="description" class="form-label fw-bold gradient-text">
                            <i class="fas fa-align-left me-2"></i>Descrição da Empresa
                        </label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="5"
                                  placeholder="Descreva sua empresa, missão, valores e o que fazem...">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between" data-aos="fade-up" data-aos-delay="500">
                        <a href="{{ route('companies.index') }}" class="btn btn-outline-secondary btn-lg">
                            <i class="fas fa-arrow-left me-2"></i>Voltar
                        </a>
                        <button type="submit" class="btn btn-primary btn-lg pulse-animation">
                            <i class="fas fa-rocket me-2"></i>Criar Empresa
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection