@extends('layouts.app')

@section('titulo', 'Moviestar - Buscar por: ' . $query)

@section('conteudo')
    <div class="container min-vh-100 mt-4 text-light">
        <div class="mb-5">
            <h1 class="display-5 text-light mb-1">Resultados da Busca</h1>
            <p class="lead text-muted">Exibindo correspondências para: <strong
                    class="text-primary">"{{ $query }}"</strong></p>
        </div>

        @php
            $hasResults =
                $filmes->isNotEmpty() ||
                $diretores->isNotEmpty() ||
                $atores->isNotEmpty() ||
                $escritores->isNotEmpty() ||
                $produtores->isNotEmpty() ||
                $estudios->isNotEmpty();
        @endphp

        @if (!$hasResults)
            <div class="card bg-dark border-secondary p-5 text-center rounded">
                <h3 class="text-light">Nenhum resultado encontrado</h3>
            </div>
        @else
            @if ($filmes->isNotEmpty())
                <div class="mb-5">
                    <h2 class="display-6 text-primary border-bottom border-secondary pb-2 mb-3">Filmes</h2>
                    <div class="row g-3">
                        @foreach ($filmes as $filme)
                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                                <div class="card bg-dark text-light border-secondary h-100 shadow-sm hover-grow"
                                    style="transition: transform 0.2s;">
                                    <a href="/filmes/{{ $filme->id }}" class="text-decoration-none text-light">
                                        <img src="{{ asset($filme->imagens->isNotEmpty() ? 'storage/' . $filme->imagens->first()->caminho : 'images/filme-card.png')}}"
                                            alt="Poster de {{ $filme->nome }}" class="card-img-top img-fluid"
                                            style="height: 280px; object-fit: cover;">
                                    </a>
                                    <div class="card-body d-flex flex-column p-3">
                                        <h5 class="card-title font-weight-bold mb-1 text-truncate"
                                            title="{{ $filme->nome }}">{{ $filme->nome }}</h5>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if ($diretores->isNotEmpty())
                <div class="mb-5">
                    <h2 class="display-6 text-primary border-bottom border-secondary pb-2 mb-3">Diretores</h2>
                    <div class="row g-3">
                        @foreach ($diretores as $diretor)
                            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
                                <div class="card bg-dark text-light border-secondary h-100 shadow-sm hover-grow"
                                    style="transition: transform 0.2s;">
                                    <a href="/pessoas/{{ $diretor->id }}" class="text-decoration-none text-light">
                                        @if ($diretor->imagens->isNotEmpty())
                                            <img src="{{ asset('storage/' . $diretor->imagens->first()->caminho) }}"
                                                alt="Foto de {{ $diretor->nome }}" class="card-img-top img-fluid"
                                                style="height: 200px; object-fit: cover;">
                                        @else
                                            <div class="d-flex align-items-center justify-content-center bg-secondary"
                                                style="height: 200px;">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48"
                                                    fill="currentColor" class="bi bi-person-fill text-dark"
                                                    viewBox="0 0 16 16">
                                                    <path
                                                        d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                                                </svg>
                                            </div>
                                        @endif
                                    </a>
                                    <div class="card-body p-2 text-center">
                                        <h6 class="card-title font-weight-bold m-0 small text-truncate"
                                            title="{{ $diretor->nome }}">{{ $diretor->nome }}</h6>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if ($atores->isNotEmpty())
                <div class="mb-5">
                    <h2 class="display-6 text-primary border-bottom border-secondary pb-2 mb-3">Atores</h2>
                    <div class="row g-3">
                        @foreach ($atores as $ator)
                            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
                                <div class="card bg-dark text-light border-secondary h-100 shadow-sm hover-grow"
                                    style="transition: transform 0.2s;">
                                    <a href="/pessoas/{{ $ator->id }}" class="text-decoration-none text-light">
                                        @if ($ator->imagens->isNotEmpty())
                                            <img src="{{ asset('storage/' . $ator->imagens->first()->caminho) }}"
                                                alt="Foto de {{ $ator->nome }}" class="card-img-top img-fluid"
                                                style="height: 200px; object-fit: cover;">
                                        @else
                                            <div class="d-flex align-items-center justify-content-center bg-secondary"
                                                style="height: 200px;">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48"
                                                    fill="currentColor" class="bi bi-person-fill text-dark"
                                                    viewBox="0 0 16 16">
                                                    <path
                                                        d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                                                </svg>
                                            </div>
                                        @endif
                                    </a>
                                    <div class="card-body p-2 text-center">
                                        <h6 class="card-title font-weight-bold m-0 small text-truncate"
                                            title="{{ $ator->nome }}">{{ $ator->nome }}</h6>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if ($escritores->isNotEmpty())
                <div class="mb-5">
                    <h2 class="display-6 text-primary border-bottom border-secondary pb-2 mb-3">Escritores</h2>
                    <div class="row g-3">
                        @foreach ($escritores as $escritor)
                            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
                                <div class="card bg-dark text-light border-secondary h-100 shadow-sm hover-grow"
                                    style="transition: transform 0.2s;">
                                    <a href="/pessoas/{{ $escritor->id }}" class="text-decoration-none text-light">
                                        @if ($escritor->imagens->isNotEmpty())
                                            <img src="{{ asset('storage/' . $escritor->imagens->first()->caminho) }}"
                                                alt="Foto de {{ $escritor->nome }}" class="card-img-top img-fluid"
                                                style="height: 200px; object-fit: cover;">
                                        @else
                                            <div class="d-flex align-items-center justify-content-center bg-secondary"
                                                style="height: 200px;">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48"
                                                    fill="currentColor" class="bi bi-person-fill text-dark"
                                                    viewBox="0 0 16 16">
                                                    <path
                                                        d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                                                </svg>
                                            </div>
                                        @endif
                                    </a>
                                    <div class="card-body p-2 text-center">
                                        <h6 class="card-title font-weight-bold m-0 small text-truncate"
                                            title="{{ $escritor->nome }}">{{ $escritor->nome }}</h6>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if ($produtores->isNotEmpty())
                <div class="mb-5">
                    <h2 class="display-6 text-primary border-bottom border-secondary pb-2 mb-3">Produtores</h2>
                    <div class="row g-3">
                        @foreach ($produtores as $produtor)
                            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
                                <div class="card bg-dark text-light border-secondary h-100 shadow-sm hover-grow"
                                    style="transition: transform 0.2s;">
                                    <a href="/pessoas/{{ $produtor->id }}" class="text-decoration-none text-light">
                                        @if ($produtor->imagens->isNotEmpty())
                                            <img src="{{ asset('storage/' . $produtor->imagens->first()->caminho) }}"
                                                alt="Foto de {{ $produtor->nome }}" class="card-img-top img-fluid"
                                                style="height: 200px; object-fit: cover;">
                                        @else
                                            <div class="d-flex align-items-center justify-content-center bg-secondary"
                                                style="height: 200px;">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48"
                                                    fill="currentColor" class="bi bi-person-fill text-dark"
                                                    viewBox="0 0 16 16">
                                                    <path
                                                        d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                                                </svg>
                                            </div>
                                        @endif
                                    </a>
                                    <div class="card-body p-2 text-center">
                                        <h6 class="card-title font-weight-bold m-0 small text-truncate"
                                            title="{{ $produtor->nome }}">{{ $produtor->nome }}</h6>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if ($estudios->isNotEmpty())
                <div class="mb-5">
                    <h2 class="display-6 text-primary border-bottom border-secondary pb-2 mb-3">Estúdios</h2>
                    <div class="row g-3">
                        @foreach ($estudios as $estudio)
                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                                <div class="card bg-dark text-light border-secondary h-100 shadow-sm hover-grow"
                                    style="transition: transform 0.2s;">
                                    <a href="/estudios/{{ $estudio->id }}" class="text-decoration-none text-light">
                                        @if ($estudio->imagens->isNotEmpty())
                                            <img src="{{ asset('storage/' . $estudio->imagens->first()->caminho) }}"
                                                alt="Imagem de {{ $estudio->nome }}" class="card-img-top img-fluid"
                                                style="height: 200px; object-fit: cover;">
                                        @else
                                            <div class="d-flex align-items-center justify-content-center bg-secondary"
                                                style="height: 200px;">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48"
                                                    fill="currentColor" class="bi bi-building text-dark"
                                                    viewBox="0 0 16 16">
                                                    <path
                                                        d="M4 2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zM4 5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zM7.5 5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm3.5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zM4.5 8a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm2.5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5z" />
                                                    <path
                                                        d="M2 1a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1zm11 0H3v14h3v-2.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5V15h3z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </a>
                                    <div class="card-body p-3">
                                        <h5 class="card-title font-weight-bold mb-2 text-truncate"
                                            title="{{ $estudio->nome }}">{{ $estudio->nome }}</h5>
                                        <p class="card-text text-muted small mb-0">
                                            @if ($estudio->local)
                                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                                    fill="currentColor" class="bi bi-geo-alt-fill me-1"
                                                    viewBox="0 0 16 16">
                                                    <path
                                                        d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6" />
                                                </svg>
                                                {{ $estudio->local }}
                                            @else
                                                <span class="text-secondary-50 italic">Local não informado</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endif
    </div>

    <style>
        .hover-grow:hover {
            transform: scale(1.05);
        }
    </style>
@endsection
