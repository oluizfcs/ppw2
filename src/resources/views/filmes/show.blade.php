@extends('layouts.app')

@section('titulo', 'Sistema - Início')

@section('conteudo')
    <div class="container">
        <div class="row mt-3">
            <div class="col-md-3">
                <img src="{{ asset('storage/' . $filme->imagens[0]->caminho) }}"
                    alt="Poster de {{ $filme->imagens[0]->nome}}"
                    class="img-fluid">
                <p class="mb-0">Duração: {{ $filme->duracao }}</p>
                <p class="mb-0">Classificação: {{ $filme->classificacao }}</p>
                <small class="text-muted">{{ $filme->data_lancamento }}</small>
            </div>
            <div class="col-md-9">
                <h1>{{ $filme->nome }}</h1>
                ★★★★★
                <p class="mb-0">Sinopse: {{ $filme->sinopse }}</p>
            </div>
        </div>

        <div class="container mt-5"> 
            <h1>Avaliações:</h1>
            <select name="stars" id="stars">
                <option value="5">★★★★★</option>
                <option value="4">★★★★</option>
                <option value="3">★★★</option>
                <option value="2">★★</option>
                <option value="1">★</option>
            </select>
            <div class="row">
                @foreach ($avaliacoes as $av)
                <div class="card mb-2">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <strong>{{ $av->usuario->name }}</strong>
                            <span class="badge bg-primary">{{ $av->nota }} ★</span>
                        </div>
                        <p class="mb-0">{{ $av->descricao }}</p>
                        <small class="text-muted">{{ $av->created_at->diffForHumans() }}</small>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection