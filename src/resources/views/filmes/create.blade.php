@extends('layouts.app')

@section('titulo', 'Sistema - Início')

@section('conteudo')
    <div class="container">
        <form action='/filmes' method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="nome">Nome:</label>
            <input type="text" class="form-control" id="nome" name="nome" value="{{ old('nome') }}">
        </div>
        <div class="form-group">
            <label for="sinopse">Sinopse</label>
            <textarea class="form-control" id="sinopse" name="sinopse">{{ old('sinopse') }}</textarea>
        </div>
        <div class="form-group">
            <label for="duracao">Duração em segundos:</label>
            <input type="number" class="form-control" id="duracao" name="duracao" value="{{ old('duracao') }}">
        </div>
        <div class="form-group">
            <label for="data_lancamento">Data de lançamento</label>
            <input type="date" class="form-control" id="data_lancamento" name="data_lancamento" value="{{ old('data_lancamento') }}">
        </div>
        <div class="form-group">
            <label for="classificacao">Classificação</label>
            <input type="text" class="form-control" id="classificacao" name="classificacao" value="{{ old('classificacao') }}">
        </div>
        <div class="form-group">
            <label for="poster">Poster</label>
            <input type="file" class="form-control" id="poster" name="poster" value="{{ old('poster') }}">
        </div>
        <button type="submit" class="btn btn-primary mt-2">Cadastrar Filme</button>
        </form>
    </div>
@endsection