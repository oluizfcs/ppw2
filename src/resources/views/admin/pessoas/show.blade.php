@extends('layouts.app')

@section('titulo', 'Moviestar - ' . $pessoa->nome)

@section('conteudo')
    <div class="container min-vh-100 mt-4 text-light">
        <div class="row">
            <div class="col-lg-4 col-md-5 mb-4">
                <div class="card bg-dark border-secondary p-3 shadow">
                    <img src="{{ asset($pessoa->imagens->isNotEmpty() ? 'storage/' . $pessoa->imagens->first()->caminho : 'images/profile.png') }}"
                        alt="Foto de {{ $pessoa->nome }}" class="img-fluid rounded shadow-sm mb-3"
                        style="width: 100%; max-height: 450px; object-fit: cover;">

                    <h4 class="border-bottom border-secondary pb-2">Informações Pessoais</h4>
                    <p class="mb-2"><strong>CPF:</strong> <span class="text-muted">{{ $pessoa->cpf }}</span></p>
                    <p class="mb-2"><strong>Gênero:</strong> <span class="text-muted">{{ $pessoa->genero }}</span></p>
                    <p class="mb-2"><strong>Nacionalidade:</strong> <span
                            class="text-muted">{{ $pessoa->nacionalidade }}</span></p>
                    <p class="mb-2"><strong>Data de Nascimento:</strong> <span
                            class="text-muted">{{ $pessoa->data_nascimento }}</span>
                    </p>
                </div>
            </div>

            <div class="col-lg-8 col-md-7">
                <h1 class="display-4 font-weight-bold mb-3">{{ $pessoa->nome }}</h1>

                <div class="card bg-dark border-secondary p-4 mb-4 shadow">
                    <h3 class="border-bottom border-secondary pb-2 mb-3">Biografia</h3>
                    <p style="font-size: 1.1rem; line-height: 1.8; text-align: justify;" class="text-light-50">
                        {!! nl2br(e($pessoa->biografia)) !!}
                    </p>
                </div>

                <div class="card bg-dark border-secondary p-4 shadow">
                    <h3 class="border-bottom border-secondary pb-2 mb-4">Fotos</h3>
                    <div class="row g-3">
                        @forelse ($pessoa->imagens as $imagem)
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <a href="{{ asset('storage/' . $imagem->caminho) }}" target="_blank">
                                    <img src="{{ asset('storage/' . $imagem->caminho) }}"
                                        alt="Fotos de {{ $pessoa->nome }}"
                                        class="img-thumbnail bg-dark border-secondary p-1"
                                        style="width: 100%; height: 130px; object-fit: cover; transition: transform 0.2s;">
                                </a>
                            </div>
                        @empty
                            <div class="col-12">
                                <p class="text-muted m-0">Nenhuma foto cadastrada.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
