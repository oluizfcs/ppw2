@extends('layouts.app')

@section('titulo', 'Moviestar - Estúdios')

@section('conteudo')
    <div class="container min-vh-100 mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="display-5 text-light m-0">Estúdios</h1>
            <a class="btn btn-primary btn-lg" href="{{ route('admin.estudios.create') }}">Cadastrar Estúdio</a>
        </div>

        <div class="row g-4">
            @forelse ($estudios as $estudio)
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                    <div class="card bg-dark text-light border-secondary h-100 shadow-sm">
                        <a href="{{ route('admin.estudios.show', $estudio->id) }}" class="text-decoration-none text-light">
                            @if ($estudio->imagens->isNotEmpty())
                                <img src="{{ asset('storage/' . $estudio->imagens->first()->caminho) }}" 
                                     alt="Imagem de {{ $estudio->nome }}" 
                                     class="card-img-top img-fluid"
                                     style="height: 200px; object-fit: cover;">
                            @else
                                <div class="d-flex align-items-center justify-content-center bg-secondary" style="height: 200px;">
                                    <div class="text-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-building text-dark" viewBox="0 0 16 16">
                                            <path d="M4 2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zM4 5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zM7.5 5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm3.5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zM4.5 8a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm2.5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5z"/>
                                            <path d="M2 1a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1zm11 0H3v14h3v-2.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5V15h3z"/>
                                        </svg>
                                        <div class="mt-2 text-dark font-weight-bold">Sem Imagem</div>
                                    </div>
                                </div>
                            @endif
                        </a>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title font-weight-bold mb-2">{{ $estudio->nome }}</h5>
                            <p class="card-text text-muted mb-4 small">
                                @if ($estudio->local)
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-geo-alt-fill me-1" viewBox="0 0 16 16">
                                        <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6"/>
                                    </svg>
                                    {{ $estudio->local }}
                                @else
                                    <span class="text-secondary-50 italic">Localização não informada</span>
                                @endif
                            </p>
                            
                            <div class="pt-2 border-top border-secondary">
                                <div class="row">
                                    <div class="col">
                                        <a href="{{ route('admin.estudios.edit', $estudio->id) }}"
                                            class="btn btn-outline-warning btn-sm w-100">Editar</a>
                                    </div>
                                    <div class="col">
                                        <form action="{{ route('admin.estudios.destroy', $estudio->id) }}" method="POST" class="d-inline"
                                            onsubmit="return confirm('Tem certeza que deseja excluir este estúdio?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm w-100">Excluir</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <p class="lead text-muted">Nenhum estúdio cadastrado.</p>
                </div>
            @endforelse
        </div>

        <div class="d-flex justify-content-center mt-5">
            {{ $estudios->links() }}
        </div>
    </div>
@endsection
