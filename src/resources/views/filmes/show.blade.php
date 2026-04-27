@extends('layouts.app')

@section('titulo', 'Sistema - Início')

@section('conteudo')
<div class="container">
<h1>Filme: {{ $filme->nome }}</h1>

<div>
    <p>Duração: {{ $filme->duracao }}</p>
    <p>Data Lançamento: {{ $filme->data_lancamento }}</p>
</div>

    @foreach ($avaliacoes as $av)
    <div class="card mb-2">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <strong>{{ $av->usuario->name }}</strong>
                <span class="badge bg-primary">{{ $av->nota }}/10</span>
            </div>
            <p class="mb-0">{{ $av->descricao }}</p>
            <small class="text-muted">{{ $av->created_at->diffForHumans() }}</small>
        </div>
    </div>
    @endforeach
</div>

@endsection