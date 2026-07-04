@extends('layouts.app')

@section('titulo', 'Cadastrar Filme')

@section('conteudo')
    <div class="container mt-5 min-vh-100">
        <div class="row justify-content-center">
            <div class="col-md-6 col-sm-12">
                <div class="display-4 text-center mb-2">Cadastrar Filme</div>
                <form action='{{ route('admin.filmes.store') }}' id="form-movie" method="POST" enctype="multipart/form-data"
                    class="card p-5 needs-validation bg-dark border-secondary" novalidate>
                    @csrf
                    @include('admin/filmes/form')
                    <button type="submit" class="btn btn-primary mt-2">Cadastrar Filme</button>
                </form>
            </div>
        </div>
    </div>
@endsection
