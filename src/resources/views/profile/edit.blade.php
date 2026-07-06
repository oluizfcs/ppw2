@extends('layouts.app')

@section('titulo', 'Editar Perfil')

@section('conteudo')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8 col-sm-12">
                <div class="card p-5 mb-4 bg-dark">
                    <div class="text-center mb-4">
                        <img src="{{ $user->getProfilePictureUrlPath() }}" alt="Foto de perfil"
                            class="rounded-circle border border-2 border-secondary"
                            style="width: 120px; height: 120px; object-fit: cover;">
                    </div>

                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('patch')

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control @error('name', 'default') is-invalid @enderror"
                                id="name" name="name" value="{{ old('name', $user->name) }}" required
                                placeholder="Nome">
                            <label for="name">Nome</label>
                            @error('name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-floating mb-3">
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                name="email" value="{{ old('email', $user->email) }}" required placeholder="Email">
                            <label for="email">Email</label>
                            @error('email')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="foto_perfil" class="form-label fw-semibold">Foto de perfil</label>
                            <input type="file" class="form-control @error('foto_perfil') is-invalid @enderror"
                                id="foto_perfil" name="foto_perfil" accept="image/*">
                            @error('foto_perfil')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </form>
                </div>

                <div class="card p-5 mb-4 bg-dark">
                    <h2 class="fw-bold mb-4">Alterar Senha</h2>

                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        @method('put')

                        <div class="form-floating mb-3">
                            <input type="password"
                                class="form-control @error('current_password', 'updatePassword') is-invalid @enderror"
                                id="current_password" name="current_password" placeholder="Senha atual">
                            <label for="current_password">Senha atual</label>
                            @error('current_password', 'updatePassword')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-floating mb-3">
                            <input type="password"
                                class="form-control @error('password', 'updatePassword') is-invalid @enderror"
                                id="password" name="password" placeholder="Nova senha">
                            <label for="password">Nova senha</label>
                            @error('password', 'updatePassword')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-floating mb-3">
                            <input type="password"
                                class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror"
                                id="password_confirmation" name="password_confirmation" placeholder="Confirmar nova senha">
                            <label for="password_confirmation">Confirmar nova senha</label>
                            @error('password_confirmation', 'updatePassword')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
