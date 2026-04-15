@extends('layouts.app')

@section('titulo', 'Detalhar produto')

@section('conteudo')
    @isset ($produto)
    <div class="col-md-8 mx-auto mt-4 mb-4">
        <div class="card" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title">{{ $produto->nome }}</h5>
                <h6 class="card-subtitle mb-2 text-body-secondary">R$ {{ number_format($produto->preco, 2, ',', '.') }}</h6>
                <p class="card-text">
                    @if ($produto->ativo)
                        <span class='badge bg-success'>Disponível</span>
                    @else
                        <span class='badge bg-secondary'>Indisponível</span>
                    @endif
                </p>
                <a href="/produtos" class="btn btn-primary">Voltar</a>
            </div>
        </div>
    </div>
    @endisset

    @includeWhen($produto == null, 'partials.alerta', ['message' => 'Este produto não existe.'])
@endsection