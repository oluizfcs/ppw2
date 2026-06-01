@extends('layouts.app')

@section('titulo', 'Editar Estúdio')

@section('conteudo')
    <div class="container mt-5 min-vh-100">
        <div class="row justify-content-center">
            <div class="col-md-6 col-sm-12">
                <div class="display-4 text-center mb-2">Editar Estúdio</div>
                <form action='/estudios/{{ $estudio->id }}' method="POST" enctype="multipart/form-data" class="card p-5 needs-validation bg-dark" novalidate>
                    @csrf
                    @method('PUT')
                    @include('estudios/form', ['estudio' => $estudio])
                    <button type="submit" class="btn btn-primary mt-2">Editar Estúdio</button>
                </form>
            </div>
        </div>
    </div>
@endsection
