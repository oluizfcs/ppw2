@extends('layouts.app')

@section('titulo', 'Moviestar - Esqueci a senha')

@section('conteudo')
    <div class="container mt-5 min-vh-100">
        <div class="row justify-content-center">
            <div class="col-md-6 col-sm-12">
                <div class="fs-2 text-center mb-2">Esqueceu sua senha? não tem problema!</div>
                <form action="{{ route('password.email') }}" method="POST" class="card p-5 needs-validation bg-dark" novalidate>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="email" name="email" autofocus value="{{ old('email') }}"
                            pattern="^[^\s@]+@[^\s@]+\.[^\s@]+$" required placeholder="seu@email.com">
                        <label for="email">Email</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Enviar e-mail de redefinição de senha</button>
                    <span class="text-center mt-2">{{ session('status') }}</span>
                </form>
            </div>
        </div>
    </div>
@endsection