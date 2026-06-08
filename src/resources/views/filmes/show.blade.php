@extends('layouts.app')

@section('titulo', 'Sistema - Início')

@section('conteudo')
    <div class="container">
        <div class="row mt-3">
            <div class="col-md-3">
                <img src="{{ asset('storage/' . $filme->imagens[0]->caminho) }}"
                    alt="Poster de {{ $filme->imagens[0]->nome }}" class="img-fluid">
                <p class="mb-0">Duração: {{ $filme->duracao }}</p>
                <p class="mb-0">Classificação: {{ $filme->classificacao }}</p>
                <p class="mb-0">Gêneros: {{ implode(', ', $generos) }}</p>
                <p class="mb-0">Estudios: {{ implode(', ', $estudios) }}</p>
                <small class="text-muted">{{ $filme->data_lancamento }}</small>
            </div>
            <div class="col-md-9">
                <h1>{{ $filme->nome }}</h1>
                ★★★★★
                <p class="mb-0">Sinopse: {{ $filme->sinopse }}</p>
            </div>
        </div>

        <div class="row mt-3">
            <div class="display-4">Imagens</div>
            @forelse ($filme->imagens as $imagem)
                <div class="col">
                    <img src="{{ asset('storage/' . $imagem->caminho) }}" alt="" width="200px">
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <p class="fs-5 text-muted">Nenhuma imagem encontrada.</p>
                </div>
            @endforelse
            <div class="row mt-4">
                <h2 class="display-5 text-light mb-3">Diretores</h2>
                @forelse ($filme->diretores as $diretor)
                    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
                        <div class="card bg-dark text-light border-secondary h-100 shadow-sm">
                            <a href="/pessoas/{{ $diretor->pessoa->id }}" class="text-decoration-none text-light">
                                @if ($diretor->pessoa->imagens->isNotEmpty())
                                    <img src="{{ asset('storage/' . $diretor->pessoa->imagens->first()->caminho) }}"
                                        alt="Foto de {{ $diretor->pessoa->nome }}" class="card-img-top img-fluid"
                                        style="height: 200px; object-fit: cover;">
                                @else
                                    <div class="d-flex align-items-center justify-content-center bg-secondary"
                                        style="height: 200px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48"
                                            fill="currentColor" class="bi bi-person-fill text-dark" viewBox="0 0 16 16">
                                            <path
                                                d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                                        </svg>
                                    </div>
                                @endif
                            </a>
                            <div class="card-body p-2 text-center">
                                <h6 class="card-title font-weight-bold m-0 small text-truncate"
                                    title="{{ $diretor->pessoa->nome }}">{{ $diretor->pessoa->nome }}</h6>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-muted small">Nenhum diretor cadastrado.</div>
                @endforelse
            </div>

            <div class="row mt-4">
                <h2 class="display-5 text-light mb-3">Produtores</h2>
                @forelse ($filme->produtores as $produtor)
                    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
                        <div class="card bg-dark text-light border-secondary h-100 shadow-sm">
                            <a href="/pessoas/{{ $produtor->pessoa->id }}" class="text-decoration-none text-light">
                                @if ($produtor->pessoa->imagens->isNotEmpty())
                                    <img src="{{ asset('storage/' . $produtor->pessoa->imagens->first()->caminho) }}"
                                        alt="Foto de {{ $produtor->pessoa->nome }}" class="card-img-top img-fluid"
                                        style="height: 200px; object-fit: cover;">
                                @else
                                    <div class="d-flex align-items-center justify-content-center bg-secondary"
                                        style="height: 200px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48"
                                            fill="currentColor" class="bi bi-person-fill text-dark" viewBox="0 0 16 16">
                                            <path
                                                d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                                        </svg>
                                    </div>
                                @endif
                            </a>
                            <div class="card-body p-2 text-center">
                                <h6 class="card-title font-weight-bold m-0 small text-truncate"
                                    title="{{ $produtor->pessoa->nome }}">{{ $produtor->pessoa->nome }}</h6>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-muted small">Nenhum produtor cadastrado.</div>
                @endforelse
            </div>

            <div class="row mt-4">
                <h2 class="display-5 text-light mb-3">Escritores</h2>
                @forelse ($filme->escritores as $escritor)
                    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
                        <div class="card bg-dark text-light border-secondary h-100 shadow-sm">
                            <a href="/pessoas/{{ $escritor->pessoa->id }}" class="text-decoration-none text-light">
                                @if ($escritor->pessoa->imagens->isNotEmpty())
                                    <img src="{{ asset('storage/' . $escritor->pessoa->imagens->first()->caminho) }}"
                                        alt="Foto de {{ $escritor->pessoa->nome }}" class="card-img-top img-fluid"
                                        style="height: 200px; object-fit: cover;">
                                @else
                                    <div class="d-flex align-items-center justify-content-center bg-secondary"
                                        style="height: 200px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48"
                                            fill="currentColor" class="bi bi-person-fill text-dark" viewBox="0 0 16 16">
                                            <path
                                                d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                                        </svg>
                                    </div>
                                @endif
                            </a>
                            <div class="card-body p-2 text-center">
                                <h6 class="card-title font-weight-bold m-0 small text-truncate"
                                    title="{{ $escritor->pessoa->nome }}">{{ $escritor->pessoa->nome }}</h6>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-muted small">Nenhum escritor cadastrado.</div>
                @endforelse
            </div>

            <div class="row mt-4">
                <h2 class="display-5 text-light mb-3">Atores</h2>
                @forelse ($filme->atores as $ator)
                    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
                        <div class="card bg-dark text-light border-secondary h-100 shadow-sm">
                            <a href="/pessoas/{{ $ator->pessoa->id }}" class="text-decoration-none text-light">
                                @if ($ator->pessoa->imagens->isNotEmpty())
                                    <img src="{{ asset('storage/' . $ator->pessoa->imagens->first()->caminho) }}"
                                        alt="Foto de {{ $ator->pessoa->nome }}" class="card-img-top img-fluid"
                                        style="height: 200px; object-fit: cover;">
                                @else
                                    <div class="d-flex align-items-center justify-content-center bg-secondary"
                                        style="height: 200px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48"
                                            fill="currentColor" class="bi bi-person-fill text-dark" viewBox="0 0 16 16">
                                            <path
                                                d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                                        </svg>
                                    </div>
                                @endif
                            </a>
                            <div class="card-body p-2 text-center">
                                <h6 class="card-title font-weight-bold mb-1 small text-truncate"
                                    title="{{ $ator->pessoa->nome }}">{{ $ator->pessoa->nome }}</h6>
                                <div class="text-muted small text-truncate" style="font-size: 0.8rem;"
                                    title="{{ $ator->pivot->papel }}">{{ $ator->pivot->papel }}</div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-muted small">Nenhum ator cadastrado.</div>
                @endforelse
            </div>
        </div>

        <section class="mt-5" id="secao-avaliacoes">
            <h3>Avaliações</h3>
            {{-- Container onde o JS injeta os cards de avaliação --}}
            <div id="avaliacoes-container">
                <p class="text-muted">Carregando avaliações...</p>
            </div>
            {{-- Navegação AJAX --}}
            <div class="d-flex align-items-center gap-3 mt-3">
                <button id="btn-anterior" class="btn btn-outline-secondary" disabled>
                    ← Anterior
                </button>
                <span id="info-pagina" class="text-muted"></span>
                <button id="btn-proxima" class="btn btn-outline-secondary">
                    Próxima →
                </button>
            </div>
        </section>


        <div class="container mt-5">
            <h1>Avaliações:</h1>
            <select name="stars" id="stars">
                <option value="5">★★★★★</option>
                <option value="4">★★★★</option>
                <option value="3">★★★</option>
                <option value="2">★★</option>
                <option value="1">★</option>
            </select>
            <div class="row">
                @foreach ($avaliacoes as $av)
                    <div class="card mb-2">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <strong>{{ $av->usuario->name }}</strong>
                                <span class="badge bg-primary">{{ $av->nota }} ★</span>
                            </div>
                            <p class="mb-0">{{ $av->descricao }}</p>
                            <small class="text-muted">{{ $av->created_at->diffForHumans() }}</small>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const filmeId = {{ $filme->id }};
        let paginaAtual = 1;

        function carregarAvaliacoes(pagina) {
            fetch(`/filmes/${filmeId}/avaliacoes?page=${pagina}`, {
                    headers: {
                        'Accept': 'application/json'
                    }
                })
                .then(res => {
                    if (!res.ok) throw new Error('Erro na requisição');
                    return res.json();
                })
                .then(dados => {
                    renderizarAvaliacoes(dados.data);
                    atualizarNavegacao(dados);
                    paginaAtual = dados.current_page;
                })
                .catch(erro => {
                    document.getElementById('avaliacoes-container').innerHTML =
                        '<p class="text-danger">Erro ao carregar avaliações.</p>';
                });
        }

        function renderizarAvaliacoes(avaliacoes) {
            const container = document.getElementById('avaliacoes-container');
            
            if(avaliacoes.length === 0) {
                container.textContent = "Nenhuma avaliação encontrada";
                return;
            }

            container.innerHTML = avaliacoes.map(av => `
                <div class="card mb-2">
                <div class="card-body">
                <strong>${av.usuario.name}</strong>
                <span class="badge bg-primary">${av.nota}/5</span>
                <p class="mb-0">${av.descricao ?? ''}</p>
                </div>
                </div>
                `).join('');
        }

        function atualizarNavegacao(dados) {
            document.getElementById('btn-anterior').disabled = !dados.prev_page_url;
            document.getElementById('btn-proxima').disabled = !dados.next_page_url;
            document.getElementById('info-pagina').textContent =
                `Página ${dados.current_page} de ${dados.last_page}`;
        }
        document.getElementById('btn-anterior')
            .addEventListener('click', () => carregarAvaliacoes(paginaAtual - 1));
        document.getElementById('btn-proxima')
            .addEventListener('click', () => carregarAvaliacoes(paginaAtual + 1));

        carregarAvaliacoes(1);
    </script>
@endpush
