@extends('layouts.app')

@section('titulo', 'Moviestar - ' . $estudio->nome)

@section('conteudo')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 fw-bold">Estúdio</h1>
            <div>
                @auth
                    @if (auth()->user()->isAdmin())
                        <a href="{{ route('admin.estudios.show', $estudio) }}" class="btn btn-outline-secondary me-2">Ver no
                            Painel Administrativo</a>
                    @endif
                @endauth
                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">Voltar</a>
            </div>
        </div>

        <div class="card shadow-sm border-secondary">
            <div class="card-body">
                <dl class="row mb-0">
                    <div class="clearfix">
                        @if ($estudio->imagens->isNotEmpty())
                            <img src="{{ asset('storage/' . $estudio->imagens->first()->caminho) }}"
                                alt="Imagem de {{ $estudio->nome }}" class="float-start img-thumbnail"
                                style="max-width: 300px; margin-right: 1rem">
                        @else
                            <img src="{{ asset('images/star.png') }}" alt="Estúdio sem imagem"
                                class="float-start img-thumbnail" style="max-width: 300px; margin-right: 1rem">
                        @endif
                        <h1 class="display-2">{{ $estudio->nome }}</h1>
                        Local: {{ $estudio->local ?: 'não informado' }}
                    </div>
                </dl>

                @if ($filmes->isNotEmpty())
                    @include('partials.lista-cards', [
                        'listLabel' => 'Filmes (' . $filmes->count() . ')',
                        'cardList' => $filmes,
                        'routeName' => 'filmes.show',
                    ])
                @endif

                @if ($estudio->imagens->count() > 1)
                    <hr>
                    <p class="fs-3 fw-bold">Fotos ({{ $estudio->imagens->count() - 1 }})</p>
                    @foreach ($estudio->imagens->skip(1) as $imagem)
                        <img src="{{ asset('storage/' . $imagem->caminho) }}" alt=""
                            style="max-width: 300px; border-radius: 6px;">
                    @endforeach
                @endif
            </div>
        </div>
    </div>
@endsection
