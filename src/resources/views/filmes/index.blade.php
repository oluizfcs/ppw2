@extends('layouts.app')

@section('titulo', 'Moviestar - Filmes')

@section('conteudo')
    <div class="container">
        <a class="btn btn-primary" href="/filmes/create">Cadastrar filme</a>

        <div class="row g-3">
            @forelse ($filmes as $filme)
            <div class="col-md-3">
                <a href="/filmes/{{ $filme->id }}">
                <div class="card mb-2">
                    <div class="card-body">
                        <img src="{{ asset('storage/' . $filme->imagens[0]->caminho) }}" alt="Poster de {{ $filme->imagens[0]->nome}}" class="card-img-top img-fluid">
                        <div class="d-flex justify-content-between">
                            <strong>{{ $filme->nome }}</strong>
                        </div>
                        {{-- <p class="mb-0">Sinopse: {{ $filme->sinopse }}</p>
                        <p class="mb-0">Duração: {{ $filme->duracao }}</p>
                        <p class="mb-0">Classificação: {{ $filme->classificacao }}</p>
                        <small class="text-muted">{{ $filme->data_lancamento }}</small> --}}
                        <a href="/filmes/{{ $filme->id }}/edit" class="btn btn-secondary">Editar</a>
                        <form action="/filmes/{{ $filme->id }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Excluir</button>
                        </form>
                    </div>
                </div>
                </a>
            </div>
            @empty
                <p>Nenhum filme encontrado.</p>
            @endforelse
            <div class="d-flex justify-content-center mt-4">
                {{ $filmes->links() }}
            </div>
        </div>
@endsection