<div class="form-floating mb-3">
    <input type="text" autofocus class="form-control @error('nome') is-invalid @enderror" id="nome" name="nome"
        value="{{ old('nome', $filme->nome ?? 'teste') }}" placeholder>
    <label for="nome">Nome:</label>
    @error('nome')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="form-floating mb-3">
    <textarea class="form-control @error('sinopse') is-invalid @enderror" id="sinopse" name="sinopse" placeholder>{{ old('sinopse', $filme->sinopse ?? 'teste') }}</textarea>
    <label for="sinopse">Sinopse</label>
</div>
<div class="form-floating mb-3">
    <input type="number" class="form-control @error('duracao') is-invalid @enderror" id="duracao" name="duracao"
        value="{{ old('duracao', $filme->duracao ?? '125') }}" placeholder>
    <label for="duracao">Duração em minutos:</label>
    @error('duracao')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="form-floating mb-3">
    <input type="date" class="form-control @error('data_lancamento') is-invalid @enderror" id="data_lancamento"
        name="data_lancamento" value="{{ old('data_lancamento', $filme->data_lancamento ?? '2010-10-10') }}"
        placeholder>
    <label for="data_lancamento">Data de lançamento</label>
    @error('data_lancamento')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="form-floating mb-3">
    <select class="form-control @error('classificacao') is-invalid @enderror" id="classificacao" name="classificacao">
        <option {{ old('classificacao', $filme->classificacao ?? 'L') == 'L' ? 'selected' : '' }} value="L">L
        </option>
        <option {{ old('classificacao', $filme->classificacao ?? 'L') == '6' ? 'selected' : '' }} value="6">6
        </option>
        <option {{ old('classificacao', $filme->classificacao ?? 'L') == '10' ? 'selected' : '' }} value="10">10
        </option>
        <option {{ old('classificacao', $filme->classificacao ?? 'L') == '12' ? 'selected' : '' }} value="12">12
        </option>
        <option {{ old('classificacao', $filme->classificacao ?? 'L') == '14' ? 'selected' : '' }} value="14">14
        </option>
        <option {{ old('classificacao', $filme->classificacao ?? 'L') == '16' ? 'selected' : '' }} value="16">16
        </option>
        <option {{ old('classificacao', $filme->classificacao ?? 'L') == '18' ? 'selected' : '' }} value="18">18
        </option>
    </select>
    <label for="classificacao">Classificação</label>
    @error('classificacao')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="form-group mb-3">
    <label for="generos">Gêneros</label>
    <select name="generos[]" class="form-control @error('generos') is-invalid @enderror" multiple id="generos">
        @foreach ($generos as $genero)
            <option {{ in_array($genero, old('generos', $generosDesteFilme ?? [])) ? 'selected' : '' }}
                value="{{ $genero }}">{{ ucfirst($genero) }}</option>
        @endforeach
    </select>
    @error('generos')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
@if (isset($estudios) && $estudios->isNotEmpty())
    <div class="form-group mb-3">
        <label for="estudios">Estúdios</label>
        <select name="estudios[]" class="form-control @error('estudios') is-invalid @enderror" multiple id="estudios">
            @foreach ($estudios as $id => $nome)
                <option {{ in_array($id, old('estudios', $estudiosDesteFilme ?? [])) ? 'selected' : '' }}
                    value="{{ $id }}">{{ $nome }}</option>
            @endforeach
        </select>
        @error('estudios')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
@endif

<h4 class="text-light border-bottom border-secondary pb-2 mt-4">Pessoas</h4>

{{-- Na partial form-filme.blade.php --}}
@if (isset($filme))
    <div class="mb-3">
        <label class="form-label fw-bold">Pessoas vinculadas</label>
        @foreach ([
        'atores' => ['label' => 'Ator', 'temPersonagem' => true],
        'diretores' => ['label' => 'Diretor', 'temPersonagem' => false],
        'produtores' => ['label' => 'Produtor', 'temPersonagem' => false],
        'escritores' => ['label' => 'Escritor', 'temPersonagem' => false],
    ] as $relacao => $config)
            @foreach ($filme->$relacao as $item)
                <div class="d-flex align-items-center gap-2 mb-2 card-vinculo-existente">
                    <span class="badge bg-secondary">{{ $config['label'] }}</span>
                    <span>{{ $item->pessoa->nome }}</span>
                    @if ($config['temPersonagem'])
                        <input type="text" name="atores_existentes[{{ $item->id }}][papel]"
                            value="{{ $item->pivot->papel }}" class="form-control form-control-sm" style="width:180px"
                            placeholder="papel">
                    @endif
                    {{-- Marcador para remoção --}}
                    <input type="checkbox" name="remover_vinculos[{{ $relacao }}][]" value="{{ $item->id }}"
                        class="form-check-input" title="Remover">
                    <label class="form-check-label text-danger small">Remover</label>
                </div>
            @endforeach
        @endforeach
    </div>
@endif
{{-- Seção de novos vínculos (mesma que na criação) --}}
{{-- removerdps --}}
<div id="vinculos-container"></div>
<button type="button" id="btn-vincular" class="btn btn-outline-secondary mt-2">
    + Vincular pessoa
</button>
{{-- Template de um card de vínculo (oculto, clonado pelo JS) --}}
<template id="template-vinculo">
    <div class="card mb-2 card-vinculo">
        <div class="card-body p-2">
            {{-- Campo de busca visível + campo oculto com o ID --}}
            <input type="text" class="form-control mb-2 campo-busca" placeholder="Buscar pelo nome da pessoa...">
            <div class="lista-resultados list-group mb-2"></div>
            <input type="hidden" name="" class="campo-pessoa-id">
            <div class="d-flex mb-1">
                <img class="foto-pessoa rounded-circle ms-2 me-2" style="max-width: 42px" alt=""
                    aria-hidden="true">
                <span class="nome-pessoa fs-3"></span>
            </div>
            <select name="" class="form-select form-select-sm mb-2 campo-tipo">
                <option value="ator">Ator</option>
                <option value="diretor">Diretor</option>
                <option value="produtor">Produtor</option>
                <option value="escritor">Escritor</option>
            </select>
            <input type="text" name="" class="form-control form-control-sm campo-papel"
                placeholder="Nome do personagem">
            <button type="button" class="btn btn-sm btn-outline-danger mt-1 btn-remover">
                Remover vínculo
            </button>
        </div>
    </div>
</template>

{{-- Bloco de imagens existentes — só aparece na edição --}}
@if (isset($filme) && $filme->imagens->isNotEmpty())
    <div class="mb-4">
        <label class="form-label fw-bold">Imagens cadastradas</label>
        <div class="d-flex flex-wrap gap-3">
            @foreach ($filme->imagens as $imagem)
                <div id="img-{{ $imagem->id }}" class="text-center campo-imagem" style="width: 130px">
                    <img src="{{ asset('storage/' . $imagem->caminho) }}" class="img-thumbnail mb-1"
                        style="height: 90px; object-fit: cover">
                    {{-- Radio para definir como poster --}}
                    <div class="form-check form-check-inline">
                        <label class="form-check-label small">
                            <input class="form-check-input" type="radio" name="poster_index"
                                {{ $imagem->pivot->poster ? 'checked' : '' }}>
                            Poster
                        </label>
                    </div>
                    {{-- Botão de remoção individual --}}
                    <button type="button"
                        onclick="excluirImagem({{ $imagem->id }}, {{ $filme->id }})"class="btn btn-outline-danger btn-sm w-100">
                        Remover
                    </button>
                </div>
            @endforeach
        </div>
    </div>
@endif

<hr>
{{-- Container que recebe os novos campos --}}
<div id="campos-imagem">
    <div class="campo-imagem mb-2 d-flex align-items-center gap-2">
        <input type="file" name="imagens[]" class="form-control" accept="image/jpeg,image/png,image/webp">
        <label class="mb-0">
            <input type="radio" class="form-check-input" name="poster_index"> Poster
        </label>
    </div>
</div>
<button type="button" id="btn-adicionar" class="btn btn-outline-secondary btn-sm">
    + Adicionar imagem
</button>

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            new TomSelect('#generos', {
                plugins: ['remove_button'],
                create: true,
                sortField: {
                    field: 'text',
                    direction: 'asc'
                },
                render: {
                    option_create: function(data, escape) {
                        return '<div class="create">Adicionar <strong>' + escape(data.input) +
                            '</strong>&hellip;</div>';
                    },
                    no_results: function(data, escape) {
                        return '<div class="no-results">Nenhum gênero encontrado</div>';
                    },
                }
            });

            if (document.getElementById('estudios')) {
                new TomSelect('#estudios', {
                    plugins: ['remove_button'],
                    create: false,
                    sortField: {
                        field: 'text',
                        direction: 'asc'
                    },
                    render: {
                        no_results: function(data, escape) {
                            return '<div class="no-results">Nenhum estúdio encontrado</div>';
                        },
                    }
                });
            }
        });

        const containerImg = document.getElementById('campos-imagem');
        const btnAdicionarImg = document.getElementById('btn-adicionar');
        let indiceImg = 1;

        function reindexarCampos() {
            const campos = document.querySelectorAll('.campo-imagem');
            campos.forEach((campo, i) => {
                const radio = campo.querySelector('input[name="poster_index"]');
                if (radio) radio.value = i;
            });
        }

        document.getElementById("form-movie").addEventListener("submit", reindexarCampos);

        btnAdicionarImg.addEventListener('click', () => {
            const div = document.createElement('div');
            div.className = 'campo-imagem mb-2 d-flex align-items-center gap-2';
            div.innerHTML = `
            <input type="file" name="imagens[]" class="form-control"
            accept="image/jpeg,image/png,image/webp">
            <label class="mb-0">
            <input type="radio" name="poster_index" value="${indiceImg}"> Poster
            </label>
            <button type="button" class="btn btn-sm btn-outline-danger"
            onclick="this.closest('.campo-imagem').remove();">✕</button>`;
            containerImg.appendChild(div);
        });

        async function excluirImagem(imagemId, filmeId) {
            if (!confirm("Realmente deseja excluir essa imagem?")) {
                return;
            }

            const response = await fetch(`/admin/imagens/${imagemId}/filme/${filmeId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                }
            });

            if (!response.ok) {
                alert("Falha ao excluir imagem");
            } else {
                const data = await response.json();
                alert(data.message);
                document.getElementById("img-" + imagemId).remove();
            }
        }

        // vínculo de pessoa feito em aula
        const filmeId = {{ $filme->id ?? 'null' }};
        const container = document.getElementById('vinculos-container');
        const template = document.getElementById('template-vinculo');
        const csrfToken = document.querySelector('input[name="_token"]').value;
        let indice = 0;
        document.getElementById('btn-vincular').addEventListener('click', () => {
            const card = template.content.cloneNode(true).querySelector('.card-vinculo');
            // Nomeia os campos com o índice atual
            card.querySelector('.campo-pessoa-id').name = `vinculos[${indice}][pessoa_id]`;
            card.querySelector('.campo-tipo').name = `vinculos[${indice}][tipo]`;
            card.querySelector('.campo-papel').name = `vinculos[${indice}][papel]`;
            inicializarCard(card);
            container.appendChild(card);
            indice++;
        });

        function inicializarCard(card) {
            const campoBusca = card.querySelector('.campo-busca');
            const listaResultados = card.querySelector('.lista-resultados');
            let timer;
            // Debounce: aguarda 300ms após o usuário parar de digitar
            campoBusca.addEventListener('input', () => {
                clearTimeout(timer);
                timer = setTimeout(() => buscarPessoas(campoBusca.value, listaResultados, card), 300);
            });
            // Exibir/ocultar campo de personagem conforme o tipo
            card.querySelector('.campo-tipo').addEventListener('change', (e) => {
                card.querySelector('.campo-papel').style.display =
                    e.target.value === 'ator' ? 'block' : 'none';
            });
            // Remover card
            card.querySelector('.btn-remover').addEventListener('click', () => {
                card.remove();
                reindexarVinculos();
            });
        }

        function buscarPessoas(termo, lista, card) {
            if (termo.length < 2) {
                lista.innerHTML = '';
                return;
            }
            fetch(`/admin/pessoas/buscar?q=${encodeURIComponent(termo)}&filme_id=${filmeId ?? ''}`, {
                    headers: {
                        'Accept': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(pessoas => {
                    lista.innerHTML = '';
                    if (pessoas.length === 0) {
                        lista.innerHTML =
                            '<span class="list-group-item text-muted">Nenhum resultado</span>';
                        return;
                    }
                    pessoas.forEach(p => {
                        const item = document.createElement('button');
                        item.type = 'button';
                        item.className = 'list-group-item list-group-item-action';
                        // Avisa se já existe vínculo deste tipo
                        const aviso = p.vinculos.length > 0 ?
                            ` <small class="text-warning">(já vinculado como ${p.vinculos.join(', ')})</small>` :
                            '';
                        item.innerHTML = `${p.nome}${aviso}`;
                        item.addEventListener('click', () => {
                            // Preenche os campos ocultos e exibe o nome selecionado
                            card.querySelector('.campo-pessoa-id').value = p.id;
                            card.querySelector('.campo-busca').value = '';
                            card.querySelector('.nome-pessoa').textContent = ' ' + p.nome;
                            if (p.foto != null) {
                                card.querySelector('.foto-pessoa').style.display = 'block';
                                card.querySelector('.foto-pessoa').src = p.foto
                            } else {
                                card.querySelector('.foto-pessoa').style.display = 'none';
                            }
                            lista.innerHTML = ''; // fecha a lista
                        });
                        lista.appendChild(item);
                    });
                })
                .catch((error) => console.error(error));
        }

        function reindexarVinculos() {
            container.querySelectorAll('.card-vinculo').forEach((card, i) => {
                card.querySelector('.campo-pessoa-id').name = `vinculos[${i}][pessoa_id]`;
                card.querySelector('.campo-tipo').name = `vinculos[${i}][tipo]`;
                card.querySelector('.campo-papel').name = `vinculos[${i}][papel]`;
            });
            indice = container.querySelectorAll('.card-vinculo').length;
        }
    </script>
@endpush
