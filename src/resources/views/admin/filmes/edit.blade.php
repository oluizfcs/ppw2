@extends('layouts.app')

@section('titulo', 'Editar Filme')

@section('conteudo')
    <div class="container mt-5 min-vh-100">
        <div class="row justify-content-center">
            <div class="col-md-6 col-sm-12">
                <div class="display-4 text-center mb-2">Editar Filme</div>
                <form action='{{ route('admin.filmes.update', $filme->id) }}' id="form-movie" method="POST"
                    enctype="multipart/form-data" class="card p-5 needs-validation bg-dark border-secondary" novalidate>
                    @csrf
                    @method('PUT')
                    @include('admin/filmes/form', ['filme' => $filme])
                    <button type="submit" class="btn btn-primary mt-2">Editar Filme</button>
                </form>
            </div>
        </div>
    </div>
@endsection
