@extends('layouts.app')

@section('titulo', 'Moviestar - ' . $filme->nome)

@section('conteudo')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 fw-bold">Filme</h1>
            <div>
                @auth
                    @if (auth()->user()->isAdmin())
                        <a href="{{ route('admin.filmes.show', $filme) }}" class="btn btn-outline-secondary me-2">Ver no Painel
                            Administrativo</a>
                    @endif
                @endauth
                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">Voltar</a>
            </div>
        </div>

        <div class="card shadow-sm border-secondary">
            <div class="card-body">
                <div class="clearfix">
                    @php $poster = $filme->poster(); @endphp
                    @if ($poster)
                        <img src="{{ asset('storage/' . $poster->caminho) }}" alt="Poster de {{ $filme->nome }}"
                            class="float-start img-thumbnail" style="max-width: 300px; margin-right: 1rem">
                    @else
                        <img src="{{ asset('images/star.png') }}" alt="Poster de {{ $filme->nome }}"
                            class="float-start img-thumbnail" style="max-width: 300px; margin-right: 1rem">
                    @endif
                    <h1 class="display-2">{{ $filme->nome }}</h1>
                    <p><i class="bi bi-star-fill text-primary"></i> {{ $filme->displayNota() }}</p>
                    {{ $filme->sinopse }}
                </div>

                <dl class="row mt-3 mb-0">
                    <dt class="col-sm-3 text-muted">Gêneros</dt>
                    <dd class="col-sm-9">{{ $filme->displayGeneros() }}</dd>

                    <dt class="col-sm-3 text-muted">Lançamento</dt>
                    <dd class="col-sm-9">{{ \Carbon\Carbon::parse($filme->data_lancamento)->format('d/m/Y') }}</dd>

                    <dt class="col-sm-3 text-muted">Duração</dt>
                    <dd class="col-sm-9">{{ $filme->displayDuracao() }}</dd>

                    <dt class="col-sm-3 text-muted">Classificação</dt>
                    <dd class="col-sm-9">{{ $filme->classificacao }}</dd>

                    <dt class="col-sm-3 text-muted">Estúdios</dt>
                    <dd class="col-sm-9">{!! $filme->displayEstudios() !!}</dd>
                </dl>

                <hr>
                <h2>Direção, Roteiro e Produção</h2>
                <dl class="row mt-3 mb-0">
                    <dt class="col-sm-3 text-muted">Diretor(es)</dt>
                    <dd class="col-sm-9">
                        @foreach ($filme->diretores as $diretor)
                            <a
                                href="{{ route('pessoas.show', $diretor->pessoa) }}">{{ $diretor->pessoa->nome }}</a>{{ !$loop->last ? ', ' : '' }}
                        @endforeach
                    </dd>

                    <dt class="col-sm-3 text-muted">Roteirista(s)</dt>
                    <dd class="col-sm-9">
                        @foreach ($filme->escritores as $escritor)
                            <a
                                href="{{ route('pessoas.show', $escritor->pessoa) }}">{{ $escritor->pessoa->nome }}</a>{{ !$loop->last ? ', ' : '' }}
                        @endforeach
                    </dd>

                    <dt class="col-sm-3 text-muted">Produtor(es)</dt>
                    <dd class="col-sm-9">
                        @foreach ($filme->produtores as $produtor)
                            <a
                                href="{{ route('pessoas.show', $produtor->pessoa) }}">{{ $produtor->pessoa->nome }}</a>{{ !$loop->last ? ', ' : '' }}
                        @endforeach
                    </dd>
                </dl>

                @if (!empty($elenco))
                    @include('partials.lista-cards', ['listLabel' => 'Elenco', 'cardList' => $elenco])
                @endif

                @if ($filme->imagens->count() > 1)
                    <hr>
                    <p class="fs-3 fw-bold">Fotos ({{ $filme->imagens->count() - 1 }})</p>
                    @foreach ($filme->imagens as $imagem)
                        @unless ($imagem->pivot->poster)
                            <img src="{{ asset('storage/' . $imagem->caminho) }}" alt=""
                                style="max-width: 300px; border-radius: 6px;">
                        @endunless
                    @endforeach
                @endif

                <hr>

                @auth
                    @if ($userReview)
                        <h2>Sua avaliação</h2>
                        @include('avaliacoes.review', ['avaliacao' => $userReview])
                    @else
                        @include('avaliacoes.form', ['filme' => $filme, 'avaliacao' => $review])
                    @endif
                    <hr>
                @endauth

                <h2>Avaliações dos usuários</h2>
                @if ($avaliacoes->count() > 0)
                    <div id="container-paginar">
                        @include('filmes._avaliacoes')
                    </div>
                @elseif (auth()->check() && $userReview)
                    <p>Só você avaliou este filme por enquanto.</p>
                @else
                    <p>Este filme não tem avaliações por enquanto.</p>
                @endif
            </div>
        </div>
    </div>

    @if ($userReview)
        <div class="modal fade" id="edit-review-modal-{{ $userReview->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <div class="modal-body">
                        @include('avaliacoes.form', [
                            'filme' => $filme,
                            'avaliacao' => $userReview,
                            'title' => 'Editar Avaliação',
                        ])
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@if ($avaliacoes->count() > 0)
    @vite('resources/js/pagination.js')
@endif
