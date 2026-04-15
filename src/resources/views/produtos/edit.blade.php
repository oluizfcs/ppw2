@extends('layouts.app')

@section('titulo', 'Sistema - Início')

@section('conteudo')
    <div class="container">
        <form action='/produtos/{{ $produto->id }}' method="POST">
        @csrf
        @method('PATCH')
        <div class="form-group">
            <label for="nome">Nome:</label>
            <input type="text" class="form-control" id="nome" name="nome" value="{{ $produto->nome }}">
        </div>
        <div class="form-group">
            <label for="preco">Preço R$:</label>
            <input type="text" class="form-control" id="preco" name="preco" value="{{ $produto->preco }}">
        </div>
        <button type="submit" class="btn btn-primary mt-2">Atualizar Produto</button>
        </form>
    </div>

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger" role="alert">
                {{ $error }}
            </div>
        @endforeach
    @endif
@endsection