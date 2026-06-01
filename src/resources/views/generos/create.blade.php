@extends('layouts.app')

@section('titulo', 'Cadastrar Gênero')

@section('conteudo')
    <div class="container mt-5 min-vh-100">
        <div class="row justify-content-center">
            <div class="col-md-6 col-sm-12">
                <div class="display-4 text-center mb-2">Cadastrar Gênero</div>
                <form action='/generos' method="POST" enctype="multipart/form-data" class="card p-5 needs-validation bg-dark border-secondary" novalidate>
                    @csrf
                    @include('generos/form')
                    <button type="submit" class="btn btn-primary mt-2">Cadastrar Gênero</button>
                </form>
            </div>
        </div>
    </div>
@endsection