@extends('layouts.app')

@section('titulo', 'Perfil de ' . $user->name)

@section('conteudo')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 fw-bold">Perfil de {{ $user->name }}</h1>
            <div>
                @auth
                    @if (auth()->id() === $user->id)
                        <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary">Editar Perfil</a>
                    @endif
                @endauth
                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">Voltar</a>
            </div>
        </div>

        <div class="card shadow-sm border-secondary">
            <div class="card-body">
                <dl class="row mb-0">
                    <div class="clearfix">
                        <img src="{{ $user->getProfilePictureUrlPath() }}" alt="Foto de perfil de {{ $user->name }}"
                            class="float-start img-thumbnail" style="max-width: 300px; margin-right: 1rem">
                        <h1 class="display-2">{{ $user->name }}</h1>
                        <p><i class="bi bi-box-arrow-in-right text-primary fs-5"></i> Entrou em
                            {{ $user->created_at->locale('pt_BR')->translatedFormat('F \de Y') }}</p>
                    </div>
                </dl>
                @if ($reviews->count() > 0)
                    <h2 class="mt-5">Avaliações do usuário ({{ $reviews->count() }})</h2>
                    @foreach ($reviews as $avaliacao)
                        @include('avaliacoes.review', ['avaliacao' => $avaliacao])
                    @endforeach
                @endif
            </div>
        </div>
    </div>

    @foreach ($reviews as $avaliacao)
        <div class="modal fade" id="edit-review-modal-{{ $avaliacao->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <div class="modal-body">
                        @include('avaliacoes.form', [
                            'avaliacao' => $avaliacao,
                            'filme' => $avaliacao->filme,
                            'title' => 'Editar Avaliação',
                        ])
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
