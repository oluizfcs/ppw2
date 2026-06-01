@extends('layouts.app')

@section('titulo', 'Editar Gênero')

@section('conteudo')
    <div class="container mt-5 min-vh-100">
        <div class="row justify-content-center">
            <div class="col-md-6 col-sm-12">
                <div class="display-4 text-center mb-2">Editar Gênero</div>
                <form action='/generos/{{ $genero->id }}' method="POST" enctype="multipart/form-data" class="card p-5 needs-validation bg-dark border-secondary" novalidate>
                    @csrf
                    @method('PUT')
                    @include('generos/form')
                    <button type="submit" class="btn btn-primary mt-2">Editar Gênero</button>
                </form>
            </div>
        </div>
    </div>
@endsection