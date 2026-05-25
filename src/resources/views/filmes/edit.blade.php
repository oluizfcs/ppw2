@extends('layouts.app')

@section('titulo', 'Atualizar Filme')

@section('conteudo')
    <div class="container mt-5 min-vh-100">
        <div class="row justify-content-center">
            <div class="col-md-6 col-sm-12">
                <div class="display-4 text-center mb-2">Atualizar Filme</div>
                <form action='/filmes/{{ $filme->id }}' method="POST" enctype="multipart/form-data" class="card p-5 needs-validation bg-dark" novalidate>
                    @csrf
                    @method('PUT')
                    @include('filmes/form', ['filme' => $filme])
                    <button type="submit" class="btn btn-primary mt-2">Atualizar Filme</button>
                </form>
            </div>
        </div>
    </div>
@endsection