@extends('layouts.app')

@section('titulo', 'Moviestar - Filme')

@section('conteudo')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 fw-bold">Filme</h1>
            <div>
                <a href="{{ route('filmes.show', $filme) }}" class="btn btn-outline-secondary me-2">Ver Página Pública</a>
                <a href="{{ route('admin.filmes.edit', $filme) }}" class="btn btn-warning me-2">Editar</a>
                <a href="{{ route('admin.filmes.index') }}" class="btn btn-outline-secondary">Voltar</a>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-sm-3 text-muted">Nome</dt>
                    <dd class="col-sm-9">{{ $filme->nome }}</dd>
                    <dt class="col-sm-3 text-muted">Duração</dt>
                    <dd class="col-sm-9">{{ $filme->duracao }}</dd>
                    <dt class="col-sm-3 text-muted">Data de lançamento</dt>
                    <dd class="col-sm-9">{{ $filme->data_lancamento }}</dd>
                    <dt class="col-sm-3 text-muted">Classificação</dt>
                    <dd class="col-sm-9">{{ $filme->classificacao }}</dd>
                    <dt class="col-sm-3 text-muted">Sinopse</dt>
                    <dd class="col-sm-9">{{ $filme->sinopse }}</dd>
                    <dt class="col-sm-3 text-muted">Gêneros</dt>
                    <dd class="col-sm-9">{{ $filme->displayGeneros() }}</dd>
                    <dt class="col-sm-3 text-muted">Estúdios</dt>
                    <dd class="col-sm-9">{{ $filme->displayEstudios() }}</dd>
                    <dt class="col-sm-3 text-muted">Pessoas</dt>
                    <dd class="col-sm-9">{!! $filme->displayPessoas() !!}</dd>
                </dl>
                <p class="fs-3 fw-bold">Fotos ({{ count($filme->imagens) }})</p>
                @forelse ($filme->imagens as $imagem)
                    <img src="{{ asset('storage/' . $imagem->caminho) }}" alt=""
                        class="{{ $imagem->pivot->poster ? 'border border-primary border-5' : '' }}"
                        style="max-width: 300px; border-raidus: 6px;">
                @empty
                    <p>Nenuma foto cadastrada.</p>
                @endforelse
            </div>
            <div class="card-footer text-end">
                <form action="{{ route('admin.filmes.destroy', $filme) }}" method="POST"
                    onsubmit="return confirm('Tem certeza que deseja excluir este filme?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Excluir</button>
                </form>
            </div>
        </div>
    </div>
@endsection
