@extends('layouts.app')

@section('titulo', 'Moviestar - Home')

@section('conteudo')
    <div class="container">
        <!-- Carrosel -->
        <div class="row justify-content-center">
            <div class="col-md-9 mt-2 mb-2">
                <div id="carouselExample" class="carousel slide">
                    <div class="carousel-inner rounded-5">
                        @foreach ($new_movies as $index => $filme)
                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                @include('partials.banner-filme', ['filme' => $filme])
                            </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExample"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Filmes -->
        <div class="fs-2 mt-4 mb-3"><span class="text-primary fw-bold">|</span> Filmes em destaque</div>
        <div class="row justify-content-center">
            @foreach ($filmes as $filme)
                @include('partials.card-filme', ['filme' => $filme])
            @endforeach
        </div>

        <!-- Atores -->
        <div class="fs-2 mt-4 mb-3"><span class="text-primary fw-bold">|</span> Atores aleatórios</div>
        <div class="row justify-content-center">
            @foreach ($atores as $ator)
                @include('partials.card-ator', ['ator' => $ator])
            @endforeach
        </div>

        <!-- Avaliações -->
        <div class="fs-2 mt-4 mb-3"><span class="text-primary fw-bold">|</span> Avaliações recentes</div>
        <div id="reviewsCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-theme="light">
            <div class="carousel-inner">
                @foreach ($avaliacoes->chunk(3) as $index => $group)
                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                        <div class="row justify-content-center">
                            @foreach ($group as $avaliacao)
                                @include('partials.card-avaliacao', ['avaliacao' => $avaliacao])
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#reviewsCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#reviewsCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
@endsection
