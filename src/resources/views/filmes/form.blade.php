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
        value="{{ old('duracao', $filme->duracao ?? '123') }}" placeholder>
    <label for="duracao">Duração em segundos:</label>
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
        <option {{ old('classificacao', $filme->classificacao ?? 'l') == 'l' ? 'selected' : '' }} value="l">L
        </option>
        <option {{ old('classificacao', $filme->classificacao ?? 'l') == '10' ? 'selected' : '' }} value="10">10
        </option>
        <option {{ old('classificacao', $filme->classificacao ?? 'l') == '12' ? 'selected' : '' }} value="12">12
        </option>
        <option {{ old('classificacao', $filme->classificacao ?? 'l') == '14' ? 'selected' : '' }} value="14">14
        </option>
        <option {{ old('classificacao', $filme->classificacao ?? 'l') == '16' ? 'selected' : '' }} value="16">16
        </option>
        <option {{ old('classificacao', $filme->classificacao ?? 'l') == '18' ? 'selected' : '' }} value="18">18
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

<div class="form-group mb-3">
    <label for="diretores">Diretores</label>
    <select name="diretores[]" class="form-control @error('diretores') is-invalid @enderror" multiple id="diretores">
        @foreach ($pessoas as $id => $nome)
            <option {{ in_array($id, old('diretores', $diretoresDesteFilme ?? [])) ? 'selected' : '' }}
                value="{{ $id }}">{{ $nome }}</option>
        @endforeach
    </select>
    @error('diretores')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group mb-3">
    <label for="produtores">Produtores</label>
    <select name="produtores[]" class="form-control @error('produtores') is-invalid @enderror" multiple id="produtores">
        @foreach ($pessoas as $id => $nome)
            <option {{ in_array($id, old('produtores', $produtoresDesteFilme ?? [])) ? 'selected' : '' }}
                value="{{ $id }}">{{ $nome }}</option>
        @endforeach
    </select>
    @error('produtores')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group mb-3">
    <label for="escritores">Escritores</label>
    <select name="escritores[]" class="form-control @error('escritores') is-invalid @enderror" multiple id="escritores">
        @foreach ($pessoas as $id => $nome)
            <option {{ in_array($id, old('escritores', $escritoresDesteFilme ?? [])) ? 'selected' : '' }}
                value="{{ $id }}">{{ $nome }}</option>
        @endforeach
    </select>
    @error('escritores')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group mb-3">
    <label for="atores">Atores</label>
    <select name="atores[]" class="form-control @error('atores') is-invalid @enderror" multiple id="atores">
        @foreach ($pessoas as $id => $nome)
            <option
                {{ in_array($id, old('atores', isset($atoresDesteFilme) ? array_keys($atoresDesteFilme) : [])) ? 'selected' : '' }}
                value="{{ $id }}">{{ $nome }}</option>
        @endforeach
    </select>
    @error('atores')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div id="papeis-atores" class="mb-3">
    @if (isset($atoresDesteFilme))
        @foreach ($atoresDesteFilme as $atorId => $papel)
            @php
                $nome = $pessoas[$atorId] ?? 'Ator';
            @endphp
            <div class="papel-input-group mb-2 d-flex align-items-center gap-2" data-id="{{ $atorId }}">
                <span class="text-light" style="min-width: 120px;">{{ $nome }}:</span>
                <input type="text" name="papeis[{{ $atorId }}]"
                    class="form-control @error('papeis.' . $atorId) is-invalid @enderror"
                    placeholder="Papel" value="{{ old('papeis.' . $atorId, $papel) }}" required>
                @error('papeis.' . $atorId)
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        @endforeach
    @endif
</div>
<hr>
<div class="form-group mb-3">
    <label for="poster">Poster</label>
    @if (isset($filme) && $filme->imagens->isNotEmpty())
        <br>
        <img src="{{ asset('storage/' . $poster->caminho) }}" class="img-thumbnail mb-1" style="width: 130px"
            alt="poster do filme">
    @endif
    <input type="file" class="form-control @error('poster') is-invalid @enderror" id="poster" name="poster">
    @error('poster')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<label for="campos-imagem">Outras imagens</label>
@if (isset($filme) && $filme->imagens->isNotEmpty())
    <div class="mb-4">
        <div class="d-flex flex-wrap gap-3">
            @foreach ($outrasImagens as $imagem)
                <div id="img-{{ $imagem->id }}" class="text-center" style="width: 130px">
                    <img src="{{ asset('storage/' . $imagem->caminho) }}" class="img-thumbnail mb-1"
                        style="height: 90px; object-fit: cover">
                    {{-- Botão de remoção individual --}}
                    <button type="button" onclick="excluirImagem({{ $imagem->id }}, {{ $filme->id }})"
                        class="btn btn-outline-danger btn-sm w-100">Remover</button>
                </div>
            @endforeach
        </div>
    </div>
@endif
<div id="campos-imagem" class="mt-2"></div>
<button type="button" id="btn-adicionar" class="btn btn-secondary mt-2">Adicionar Imagem</button>

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

            new TomSelect('#diretores', {
                plugins: ['remove_button'],
                create: false,
                sortField: {
                    field: 'text',
                    direction: 'asc'
                },
                render: {
                    no_results: function(data, escape) {
                        return '<div class="no-results">Nenhum diretor encontrado</div>';
                    },
                }
            });

            new TomSelect('#produtores', {
                plugins: ['remove_button'],
                create: false,
                sortField: {
                    field: 'text',
                    direction: 'asc'
                },
                render: {
                    no_results: function(data, escape) {
                        return '<div class="no-results">Nenhum produtor encontrado</div>';
                    },
                }
            });

            new TomSelect('#escritores', {
                plugins: ['remove_button'],
                create: false,
                sortField: {
                    field: 'text',
                    direction: 'asc'
                },
                render: {
                    no_results: function(data, escape) {
                        return '<div class="no-results">Nenhum escritor encontrado</div>';
                    },
                }
            });

            const tomSelectAtores = new TomSelect('#atores', {
                plugins: ['remove_button'],
                create: false,
                sortField: {
                    field: 'text',
                    direction: 'asc'
                },
                onChange: function(values) {
                    updatePapeisInputs(values);
                },
                render: {
                    no_results: function(data, escape) {
                        return '<div class="no-results">Nenhum ator encontrado</div>';
                    },
                }
            });

            const papeisContainer = document.getElementById('papeis-atores');

            function updatePapeisInputs(selectedIds) {
                const renderedDivs = papeisContainer.querySelectorAll('.papel-input-group');
                const renderedIds = Array.from(renderedDivs).map(div => div.dataset.id);

                renderedDivs.forEach(div => {
                    if (!selectedIds.includes(div.dataset.id)) {
                        div.remove();
                    }
                });

                selectedIds.forEach(id => {
                    if (!renderedIds.includes(id)) {
                        const option = tomSelectAtores.options[id];
                        const nome = option ? option.text : 'Ator';

                        const div = document.createElement('div');
                        div.className = 'papel-input-group mb-2 d-flex align-items-center gap-2';
                        div.dataset.id = id;
                        div.innerHTML =
                            `
                            <span class="text-light" style="min-width: 120px;">${nome}:</span>
                            <input type="text" name="papeis[${id}]" class="form-control" placeholder="Papel" required>`;
                        papeisContainer.appendChild(div);
                    }
                });
            }
        });

        const container = document.getElementById('campos-imagem');
        const btnAdicionar = document.getElementById('btn-adicionar');
        let indice = 1;
        const MAX_FOTOS = 5;
        btnAdicionar.addEventListener('click', () => {
            if (indice > MAX_FOTOS) {
                alert('Máximo de ' + MAX_FOTOS + ' imagens.');
                return;
            }
            const div = document.createElement('div');
            div.className = 'campo-imagem mb-2 d-flex align-items-center gap-2';
            div.innerHTML = `
                <input type="file" name="imagens[]" class="form-control"
                accept="image/jpeg,image/png,image/webp">
                <button type="button" class="btn btn-sm btn-outline-danger"
                onclick="this.closest('.campo-imagem').remove(); indice--;">✕</button>`;
            container.appendChild(div);
            indice++;
        });

        async function excluirImagem(imagemId, filmeId) {
            if (!confirm("Realmente deseja excluir essa imagem?")) {
                return;
            }

            const response = await fetch(`/imagens/${imagemId}/filme/${filmeId}`, {
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
                alert("Imagem removida!");
                document.getElementById("img-" + imagemId).remove();
            }
        }
    </script>
@endpush
