@extends('layouts.app')

@section('titulo', 'Moviestar - Entrar')

@section('conteudo')
    <div class="container mt-5 min-vh-100">
        <div class="row justify-content-center">
            <div class="col-md-6 col-sm-12">
                <div class="display-4 text-center mb-2">Entrar</div>
                <form action="/login" method="POST" class="card p-5 needs-validation bg-dark" novalidate>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="email" name="email" value="{{ old('email') }}"
                            pattern="^[^\s@]+@[^\s@]+\.[^\s@]+$" autofocus required placeholder="seu@email.com">
                        <label for="email">Email</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="password" name="password"
                            value="{{ old('password') }}" required placeholder="Senha">
                        <label for="password">Senha</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input mb-3" type="checkbox" value="" id="remember_me"
                            name="remember">
                        <label class="form-check-label" for="remember_me">
                            Lembre-se de mim
                        </label>
                    </div>
                    <button type="submit" class="btn btn-primary">Entrar</button>
                    <a href="/register" class="text-center mt-3">Cadastrar</a>
                    <a href="{{ route('password.request') }}" class="text-center mt-3">Esqueci minha senha</a>
                </form>
            </div>
        </div>
    </div>
@endsection
