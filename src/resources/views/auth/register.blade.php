@extends('layouts.app')

@section('titulo', 'Moviestar - Cadastrar')

@section('conteudo')
    <div class="container mt-5 min-vh-100">
        <div class="row justify-content-center">
            <div class="col-md-6 col-sm-12">
                <div class="display-4 text-center mb-2">Cadastrar</div>
                <form action="/register" method="POST" class="card p-5 needs-validation bg-dark" novalidate
                    enctype="multipart/form-data">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <h6 class="fw-bold">{{ $errors->count() }} erro(s) impediram o cadastro:</h6>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            autofocus name="name" value="{{ old('name') }}" required placeholder>
                        <label for="name">Nome</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control @error('email') is-invalid @enderror" id="email"
                            name="email" value="{{ old('email') }}" pattern="^[^\s@]+@[^\s@]+\.[^\s@]+$" required
                            placeholder="seu@email.com">
                        <label for="email">Email</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                            name="password" value="{{ old('password') }}" required placeholder="Senha">
                        <label for="password">Senha</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                            id="password_confirmation" name="password_confirmation"
                            value="{{ old('password_confirmation') }}" required placeholder="Confirmar senha">
                        <label for="password_confirmation">Confirmar Senha</label>
                    </div>

                    <div class="form-group mb-3">
                        <label for="foto_perfil">Foto de perfil:</label>
                        <input type="file" class="form-control" id="foto_perfil" name="foto_perfil"
                            value="{{ old('foto_perfil') }}">
                    </div>

                    <button type="submit" class="btn btn-primary">Cadastrar</button>
                    <a href="/login" class="text-center mt-3">Já tenho cadastro</a>
                </form>
            </div>
        </div>
    </div>
@endsection
