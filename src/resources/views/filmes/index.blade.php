@extends('layouts.app')

@section('titulo', 'Sistema - Início')

@section('conteudo')
    <div class="container">
        <a class="btn btn-primary" href="/filmes/create">Cadastrar filme</a>

        <div class="row g-3">
            @foreach ($filmes as $filme)
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
                    </div>
                </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
@endsection