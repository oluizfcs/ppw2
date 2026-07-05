@extends('layouts.app')

@section('titulo', 'Moviestar - Buscar por: ' . $query)

@section('conteudo')
    @if ($pessoas->count() + $filmes->count() > 0)
        <div class="text-center fs-5 bg-dark-subtle p-3" style="margin-top: -3rem;">
            Pesquisando por:<br>
            <span class="fs-1 text-primary">"{{ $query }}"</span>
        </div>
        <div class="container mt-3">
            <p class="fst-italic">{{ $pessoas->count() + $filmes->count() }} resultados encontrados</p>

            @unless ($pessoas->isEmpty())
                @include('partials.lista-cards', [
                    'listLabel' => 'Pessoas (' . $pessoas->count() . ')',
                    'cardList' => $pessoas,
                    'routeName' => 'pessoas.show',
                ])
            @endunless

            @unless ($filmes->isEmpty())
                @include('partials.lista-cards', [
                    'listLabel' => 'Filmes (' . $filmes->count() . ')',
                    'cardList' => $filmes,
                    'routeName' => 'filmes.show',
                ])
            @endunless
        </div>
    @else
        <div class="text-center fs-5 p-3 m-5" style="border: 3px dashed grey; border-radius: 8px">
            <span class="text-primary">Nenhum resultado encontrado para "{{ $query }}"</span><br>
            <span>Tente buscar com outras palavras</span>
        </div>
    @endif
@endsection
