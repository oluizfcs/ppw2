@extends('layouts.app')

@section('titulo', 'Moviestar - Filmes')

@section('conteudo')
    <div class="container">
        <div class="container mt-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 fw-bold">Filmes</h1>
                <a href="{{ route('admin.filmes.create') }}" class="btn btn-primary">Novo Filme</a>
            </div>
        </div>

        <div id="container-paginar">
            @include('admin.filmes._table')
        </div>
    </div>
@endsection

@vite('resources/js/pagination.js')
