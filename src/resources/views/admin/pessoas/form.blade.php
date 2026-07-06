@if ($errors->any())
    <div class="alert alert-danger">
        <h6 class="fw-bold">{{ $errors->count() }} erro(s) impediram o salvamento:</h6>
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="form-floating mb-3">
    <input type="text" autofocus class="form-control @error('nome') is-invalid @enderror" id="nome" name="nome"
        value="{{ old('nome', $pessoa->nome ?? '') }}" placeholder="Nome completo">
    <label for="nome">Nome:</label>
    @error('nome')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-floating mb-3">
    <input type="text" class="form-control @error('cpf') is-invalid @enderror" id="cpf" name="cpf"
        value="{{ old('cpf', $pessoa->cpf ?? '') }}" placeholder="000.000.000-00">
    <label for="cpf">CPF:</label>
    @error('cpf')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-floating mb-3">
    <input type="date" class="form-control @error('data_nascimento') is-invalid @enderror" id="data_nascimento"
        name="data_nascimento" value="{{ old('data_nascimento', $pessoa->data_nascimento ?? '') }}"
        placeholder="Data de Nascimento">
    <label for="data_nascimento">Data de Nascimento:</label>
    @error('data_nascimento')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-floating mb-3">
    <input type="text" class="form-control @error('genero') is-invalid @enderror" id="genero" name="genero"
        value="{{ old('genero', $pessoa->genero ?? '') }}" placeholder="Genero">
    <label for="genero">Gênero:</label>
    @error('genero')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-floating mb-3">
    <input type="text" class="form-control @error('nacionalidade') is-invalid @enderror" id="nacionalidade"
        name="nacionalidade" value="{{ old('nacionalidade', $pessoa->nacionalidade ?? '') }}"
        placeholder="Nacionalidade">
    <label for="nacionalidade">Nacionalidade:</label>
    @error('nacionalidade')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-floating mb-3">
    <textarea class="form-control @error('biografia') is-invalid @enderror" id="biografia" name="biografia"
        style="height: 120px" placeholder="Biografia">{{ old('biografia', $pessoa->biografia ?? '') }}</textarea>
    <label for="biografia">Biografia:</label>
    @error('biografia')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<h4 class="text-light border-bottom border-secondary pb-2 mt-4">Filmes</h4>

@if (isset($pessoa))
    <div class="mb-3">
        <label class="form-label fw-bold">Filmes vinculados</label>
        @foreach ([
        'ator' => ['label' => 'Ator', 'temPapel' => true],
        'diretor' => ['label' => 'Diretor', 'temPapel' => false],
        'produtor' => ['label' => 'Produtor', 'temPapel' => false],
        'escritor' => ['label' => 'Escritor', 'temPapel' => false],
    ] as $relacao => $config)
            @if ($pessoa->$relacao)
                @foreach ($pessoa->$relacao->filmes as $filme)
                    <div class="d-flex align-items-center gap-2 mb-2 card-vinculo">
                        <span class="badge bg-secondary">{{ $config['label'] }}</span>
                        <span>{{ $filme->nome }}</span>
                        @if ($config['temPapel'])
                            <input type="text"
                                name="vinculos_existentes[{{ $relacao }}][{{ $filme->id }}][papel]"
                                value="{{ $filme->pivot->papel ?? '' }}" class="form-control form-control-sm"
                                style="width:180px" placeholder="Personagem">
                        @endif
                        <input type="checkbox" name="remover_vinculos[{{ $relacao }}][]"
                            value="{{ $filme->id }}" class="form-check-input" title="Remover">
                        <label class="form-check-label text-danger small">Remover</label>
                    </div>
                @endforeach
            @endif
        @endforeach
    </div>
@endif

<div id="vinculos-container"></div>
<button type="button" id="btn-vincular" class="btn btn-outline-secondary btn-sm mt-2">
    + Vincular filme
</button>

<template id="template-vinculo">
    <div class="card mb-2 card-vinculo">
        <div class="card-body p-2">
            <input type="text" class="form-control mb-2 campo-busca" placeholder="Buscar pelo nome do filme...">
            <div class="lista-resultados list-group mb-2"></div>
            <input type="hidden" name="" class="campo-filme-id">
            <div class="d-flex mb-1">
                <img class="foto-filme rounded-circle ms-2 me-2" style="max-width: 42px" alt=""
                    aria-hidden="true">
                <span class="nome-filme fs-3"></span>
            </div>
            <select name="" class="form-select form-select-sm mb-2 campo-tipo">
                <option value="ator">Ator</option>
                <option value="diretor">Diretor</option>
                <option value="produtor">Produtor</option>
                <option value="escritor">Escritor</option>
            </select>
            <input type="text" name="" class="form-control form-control-sm campo-personagem"
                placeholder="Nome do personagem">
            <button type="button" class="btn btn-sm btn-outline-danger mt-1 btn-remover">
                Remover vínculo
            </button>
        </div>
    </div>
</template>

<div class="form-group">
    <label for="campos-imagem" class="form-label">Imagens da Pessoa</label>
    @if (isset($pessoa) && $pessoa->imagens->isNotEmpty())
        <div class="d-flex flex-wrap gap-3">
            @foreach ($pessoa->imagens as $imagem)
                <div class="text-center" id="img-container-{{ $imagem->id }}" style="width: 130px">
                    <img src="{{ asset('storage/' . $imagem->caminho) }}" class="img-thumbnail mb-1"
                        style="height: 90px; width: 120px; object-fit: cover">
                    <button type="button" onclick="excluirImagem({{ $imagem->id }}, {{ $pessoa->id }})"
                        class="btn btn-outline-danger btn-sm w-100">Remover</button>
                </div>
            @endforeach
        </div>
    @endif
</div>
<div id="campos-imagem" class="mt-2"></div>
<button type="button" id="btn-adicionar" class="btn btn-secondary mt-2">Adicionar Imagem</button>

@push('scripts')
    <script>
        const containerImg = document.getElementById('campos-imagem');
        const btnAdicionarImg = document.getElementById('btn-adicionar');

        btnAdicionarImg.addEventListener('click', () => {
            const camposAtuais = containerImg.querySelectorAll('.campo-imagem').length;
            const imagensExistentes = {{ isset($pessoa) ? $pessoa->imagens->count() : 0 }};

            const div = document.createElement('div');
            div.className = 'campo-imagem mb-2 d-flex align-items-center gap-2';
            div.innerHTML = `
                <input type="file" name="imagens[]" class="form-control"
                accept="image/jpeg,image/png,image/webp" required>
                <button type="button" class="btn btn-sm btn-outline-danger"
                onclick="this.closest('.campo-imagem').remove();">✕</button>`;
            containerImg.appendChild(div);
        });

        async function excluirImagem(imagemId, pessoaId) {
            if (!confirm("Realmente deseja excluir essa imagem?")) {
                return;
            }

            const response = await fetch(`/admin/imagens/${imagemId}/pessoa/${pessoaId}`, {
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
                const containerImg = document.getElementById(`img-container-${imagemId}`);
                if (containerImg) {
                    containerImg.remove();
                }
            }
        }

        const pessoaId = {{ $pessoa->id ?? 'null' }};
        const container = document.getElementById('vinculos-container');
        const template = document.getElementById('template-vinculo');

        let indice = document.querySelectorAll('.card-vinculo').length;

        document.getElementById('btn-vincular').addEventListener('click', () => {
            const card = template.content.cloneNode(true).querySelector('.card-vinculo');
            // Nomeia os campos com o índice atual
            card.querySelector('.campo-filme-id').name = `vinculos[${indice}][filme_id]`;
            card.querySelector('.campo-tipo').name = `vinculos[${indice}][tipo]`;
            card.querySelector('.campo-personagem').name = `vinculos[${indice}][papel]`;
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
                timer = setTimeout(() => buscarFilmes(campoBusca.value, listaResultados, card), 300);
            });
            // Exibir/ocultar campo de personagem conforme o tipo
            card.querySelector('.campo-tipo').addEventListener('change', (e) => {
                card.querySelector('.campo-personagem').style.display =
                    e.target.value === 'ator' ? 'block' : 'none';
            });
            // Remover card
            card.querySelector('.btn-remover').addEventListener('click', () => {
                card.remove();
                reindexarVinculos();
            });
        }

        function buscarFilmes(termo, lista, card) {
            if (termo.length < 2) {
                lista.innerHTML = '';
                return;
            }
            fetch(`/admin/filmes/buscar?q=${encodeURIComponent(termo)}&pessoa_id=${pessoaId ?? ''}`, {
                    headers: {
                        'Accept': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(filmes => {
                    lista.innerHTML = '';
                    if (filmes.length === 0) {
                        lista.innerHTML = '<span class="list-group-item text-muted">Nenhum resultado</span>';
                        return;
                    }

                    filmes.forEach(f => {
                        const item = document.createElement('button');
                        item.type = 'button';
                        item.className = 'list-group-item list-group-item-action';
                        // Avisa se já existe vínculo deste tipo
                        const aviso = f.vinculos.length > 0 ?
                            ` <small class="text-warning">(já vinculado como ${f.vinculos.join(', ')})</small>` :
                            '';
                        item.innerHTML = `${f.nome}${aviso}`;
                        item.addEventListener('click', () => {
                            // Preenche os campos ocultos e exibe o nome selecionado
                            card.querySelector('.campo-filme-id').value = f.id;
                            card.querySelector('.campo-busca').value = '';
                            card.querySelector('.nome-filme').textContent = ' ' + f.nome;
                            if (f.foto != null) {
                                card.querySelector('.foto-filme').style.display = 'block';
                                card.querySelector('.foto-filme').src = f.foto
                            } else {
                                card.querySelector('.foto-filme').style.display = 'none';
                            }
                            lista.innerHTML = ''; // fecha a lista
                        });
                        lista.appendChild(item);
                    });
                });
        }

        function reindexarVinculos() {
            indice = 0;
            container.querySelectorAll('.card-vinculo').forEach((card) => {
                card.querySelector('.campo-filme-id').name = `vinculos[${indice}][filme_id]`;
                card.querySelector('.campo-tipo').name = `vinculos[${indice}][tipo]`;
                card.querySelector('.campo-personagem').name = `vinculos[${indice}][papel]`;
                indice++;
            });
        }
    </script>
@endpush
