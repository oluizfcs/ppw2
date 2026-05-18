@extends('layouts.app')

@section('titulo', 'Moviestar - Home')

@section('conteudo')
    <div class="container">
        <!-- Carrosel -->
        <div class="row justify-content-center">
            <div class="col-md-9 mt-2 mb-2">
                <div id="carouselExample" class="carousel slide">
                    <div class="carousel-inner rounded-5">
                        <div class="carousel-item active">
                            <img src="{{ asset('images/yellow-banner.png') }}" class="d-block w-100" alt="yellow banner">
                        </div>
                        <div class="carousel-item">
                            <img src="{{ asset('images/black-banner.png') }}" class="d-block w-100" alt="black banner">
                        </div>
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
        <div class="fs-2 mt-4">Filmes em destaque <span class="text-primary">></span></div>
        <div class="row justify-content-center">
            @include('partials.card-filme', ['filme' => ['id' => 1, 'nome' => 'filme1']])
            @include('partials.card-filme', ['filme' => ['id' => 2, 'nome' => 'filme2']])
            @include('partials.card-filme', ['filme' => ['id' => 3, 'nome' => 'filme3']])
        </div>
        <!-- Atores -->
        <div class="fs-2 mt-4">Atores em destaque <span class="text-primary">></span></div>
        <div class="row justify-content-center">
            @include('partials.card-ator', ['ator' => ['id' => 1, 'nome' => 'Fulano']])
            @include('partials.card-ator', ['ator' => ['id' => 2, 'nome' => 'Sicrano']])
            @include('partials.card-ator', ['ator' => ['id' => 3, 'nome' => 'Beltrano']])
        </div>
        <!-- Avaliações -->
        <div class="fs-2 mt-4">Avaliações em destaque <span class="text-primary">></span></div>
        <div class="row justify-content-center">
            @include('partials.card-avaliacao', ['avaliacao' => ['nota' => 5, 'filme' => 'filme1', 'usuario' => 'Fulano']])
            @include('partials.card-avaliacao', ['avaliacao' => ['nota' => 4, 'filme' => 'filme2', 'usuario' => 'Sicrano']])
            @include('partials.card-avaliacao', ['avaliacao' => ['nota' => 3, 'filme' => 'filme3', 'usuario' => 'Beltrano']])
        </div>
    </div>
@endsection
