@extends('layouts.app')

@section('titulo', 'Moviestar - Cadastrar')

@section('conteudo')
    <div class="container mt-5 min-vh-100">
        <div class="row justify-content-center">
            <div class="col-md-6 col-sm-12">
                <div class="display-4 text-center mb-2">Cadastrar</div>
                <form action="/register" method="POST" class="card p-5 needs-validation bg-dark" novalidate>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}"
                            required placeholder>
                        <label for="name">Nome</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="email" name="email" value="{{ old('email') }}"
                            pattern="^[^\s@]+@[^\s@]+\.[^\s@]+$" required placeholder="seu@email.com">
                        <label for="email">Email</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="password" name="password"
                            value="{{ old('password') }}" required placeholder="Senha">
                        <label for="password">Senha</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                            value="{{ old('password_confirmation') }}" required placeholder="Confirmar senha">
                        <label for="password_confirmation">Confirmar Senha</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Cadastrar</button>
                    <a href="/login" class="text-center mt-3">Já tenho cadastro</a>
                </form>
            </div>
        </div>
    </div>
@endsection
