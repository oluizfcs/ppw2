@extends('layouts.app')

@section('titulo', 'Moviestar - Filmes')

@section('conteudo')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="display-5">Filmes</h1>
            <a class="btn btn-primary btn-lg" href="{{ route('admin.filmes.create') }}">Cadastrar Filme</a>
        </div>

        <div class="row g-3">
            @forelse ($filmes as $filme)
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                    <div class="card bg-dark text-light border-secondary h-100 shadow-sm">
                        <a href="{{ route('admin.filmes.show', $filme->id) }}" class="text-decoration-none text-light">
                            <img src="{{ asset('storage/' . $filme->imagens[0]->caminho) }}" alt="Poster de {{ $filme->imagens[0]->nome}}" class="img-fluid rounded shadow-sm mb-3" style="object-fit: fill">
                        </a>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title font-weight-bold mb-1">{{ $filme->nome }}</h5>
                            <div class="pt-2 border-top border-secondary">
                                <div class="row">
                                    <div class="col">
                                        <a href="{{ route('admin.filmes.edit', $filme->id) }}"
                                            class="btn btn-outline-warning btn-sm w-100">Editar</a>
                                    </div>
                                    <div class="col">
                                        <form action="{{ route('admin.filmes.destroy', $filme->id) }}" method="POST" class="d-inline"
                                            onsubmit="return confirm('Tem certeza que deseja excluir este filme?');">
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
                    <p class="fs-5 text-muted">Nenhum filme encontrado.</p>
                </div>
            @endforelse
            <div class="d-flex justify-content-center mt-4">
                {{ $filmes->links() }}
            </div>
        </div>
@endsection