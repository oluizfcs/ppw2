@extends('layouts.app')

@section('titulo', 'Moviestar - ' . $pessoa->nome)

@section('conteudo')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 fw-bold">Pessoa</h1>
            <div>
                @auth
                    @if (auth()->user()->isAdmin())
                        <a href="{{ route('admin.pessoas.show', $pessoa) }}" class="btn btn-outline-secondary me-2">Ver no Painel
                            Administrativo</a>
                    @endif
                @endauth
                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">Voltar</a>
            </div>
        </div>

        @if (session('notice'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('notice') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
            </div>
        @endif

        <div class="card shadow-sm border-secondary">
            <div class="card-body">
                <dl class="row mb-0">
                    <div class="clearfix">
                        @if ($pessoa->imagens->isNotEmpty())
                            <img src="{{ asset('storage/' . $pessoa->imagens->first()->caminho) }}"
                                alt="Foto de {{ $pessoa->nome }}" class="float-start img-thumbnail"
                                style="max-width: 300px; margin-right: 1rem">
                        @else
                            <img src="{{ asset('images/profile.png') }}" alt="Foto de {{ $pessoa->nome }}"
                                class="float-start img-thumbnail" style="max-width: 300px; margin-right: 1rem">
                        @endif
                        <h1 class="display-2">{{ $pessoa->nome }}</h1>
                        {{ $pessoa->biografia }}
                    </div>
                </dl>

                @isset($credits['ator'])
                    @include('partials.lista-cards', [
                        'listLabel' => 'Atuou em',
                        'cardList' => $credits['ator'],
                    ])
                @endisset

                @isset($credits['diretor'])
                    @include('partials.lista-cards', [
                        'listLabel' => 'Dirigiu',
                        'cardList' => $credits['diretor'],
                    ])
                @endisset

                @isset($credits['escritor'])
                    @include('partials.lista-cards', [
                        'listLabel' => 'Escreveu',
                        'cardList' => $credits['escritor'],
                    ])
                @endisset

                @isset($credits['produtor'])
                    @include('partials.lista-cards', [
                        'listLabel' => 'Produziu',
                        'cardList' => $credits['produtor'],
                    ])
                @endisset

                @if ($pessoa->imagens->count() > 1)
                    <hr>
                    <p class="fs-3 fw-bold">Fotos ({{ $pessoa->imagens->count() - 1 }})</p>
                    @foreach ($pessoa->imagens->skip(1) as $imagem)
                        <img src="{{ asset('storage/' . $imagem->caminho) }}" alt=""
                            style="max-width: 300px; border-radius: 6px;">
                    @endforeach
                @endif
            </div>
        </div>
    </div>
@endsection
