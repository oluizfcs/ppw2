@extends('layouts.app')

@section('titulo', 'Cadastrar Estúdio')

@section('conteudo')
    <div class="container mt-5 min-vh-100">
        <div class="row justify-content-center">
            <div class="col-md-6 col-sm-12">
                <div class="display-4 text-center mb-2">Cadastrar Estúdio</div>
                <form action='/estudios' method="POST" enctype="multipart/form-data" class="card p-5 needs-validation bg-dark" novalidate>
                    @csrf
                    @include('estudios/form')
                    <button type="submit" class="btn btn-primary mt-2">Cadastrar Estúdio</button>
                </form>
            </div>
        </div>
    </div>
@endsection
