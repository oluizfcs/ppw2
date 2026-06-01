@extends('layouts.app')

@section('titulo', 'Moviestar - ' . $estudio->nome)

@section('conteudo')
    <div class="container min-vh-100 mt-4 text-light">
        <a href="/estudios" class="btn btn-outline-secondary mb-4">&larr; Voltar para a Lista</a>

        <div class="row">
            <!-- Sidebar with Main Info -->
            <div class="col-lg-4 col-md-5 mb-4">
                <div class="card bg-dark border-secondary p-3 shadow">
                    @if ($estudio->imagens->isNotEmpty())
                        <img src="{{ asset('storage/' . $estudio->imagens->first()->caminho) }}"
                            alt="Imagem de {{ $estudio->nome }}"
                            class="img-fluid rounded shadow-sm mb-3"
                            style="width: 100%; max-height: 400px; object-fit: cover;">
                    @else
                        <div class="d-flex align-items-center justify-content-center bg-secondary rounded mb-3" style="width: 100%; height: 280px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-building text-dark" viewBox="0 0 16 16">
                                <path d="M4 2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zM4 5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zM7.5 5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm3.5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zM4.5 8a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm2.5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5z"/>
                                <path d="M2 1a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1zm11 0H3v14h3v-2.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5V15h3z"/>
                            </svg>
                        </div>
                    @endif

                    <h4 class="border-bottom border-secondary pb-2">Informações</h4>
                    <p class="mb-2"><strong>Nome:</strong> <span class="text-muted">{{ $estudio->nome }}</span></p>
                    <p class="mb-2">
                        <strong>Localização:</strong> 
                        <span class="text-muted">
                            {{ $estudio->local ?: 'Não informada' }}
                        </span>
                    </p>
                    
                    <div class="mt-4 pt-2 border-top border-secondary d-flex gap-2">
                        <a href="/estudios/{{ $estudio->id }}/edit" class="btn btn-warning flex-grow-1">Editar Estúdio</a>
                        <form action="/estudios/{{ $estudio->id }}" method="POST" class="d-inline flex-grow-1" onsubmit="return confirm('Tem certeza que deseja excluir este estúdio?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100">Excluir</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="col-lg-8 col-md-7">
                <h1 class="display-4 font-weight-bold mb-4">{{ $estudio->nome }}</h1>

                <!-- Photos Gallery -->
                <div class="card bg-dark border-secondary p-4 shadow">
                    <h3 class="border-bottom border-secondary pb-2 mb-4">Galeria de Imagens</h3>
                    <div class="row g-3">
                        @forelse ($estudio->imagens as $imagem)
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <a href="{{ asset('storage/' . $imagem->caminho) }}" target="_blank">
                                    <img src="{{ asset('storage/' . $imagem->caminho) }}" 
                                         alt="Galeria de {{ $estudio->nome }}" 
                                         class="img-thumbnail bg-dark border-secondary p-1"
                                         style="width: 100%; height: 130px; object-fit: cover; transition: transform 0.2s;">
                                </a>
                            </div>
                        @empty
                            <div class="col-12">
                                <p class="text-muted m-0">Nenhuma foto cadastrada na galeria.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
