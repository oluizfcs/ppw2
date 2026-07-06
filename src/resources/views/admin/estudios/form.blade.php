<div class="form-floating mb-3">
    <input type="text" autofocus class="form-control @error('nome') is-invalid @enderror" id="nome" name="nome"
        value="{{ old('nome', $estudio->nome ?? '') }}" placeholder="Nome do Estúdio" required>
    <label for="nome">Nome do Estúdio:</label>
    @error('nome')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-floating mb-3">
    <input type="text" class="form-control @error('local') is-invalid @enderror" id="local" name="local"
        value="{{ old('local', $estudio->local ?? '') }}" placeholder="Localização">
    <label for="local">Localização (opcional):</label>
    @error('local')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

@if (isset($filmes) && $filmes->isNotEmpty())
    <div class="form-group mb-3">
        <label for="filmes">Filmes</label>
        <select name="filmes[]" class="form-control @error('filmes') is-invalid @enderror" multiple id="filmes">
            @foreach ($filmes as $id => $nome)
                <option {{ in_array($id, old('filmes', $filmesDesteEstudio ?? [])) ? 'selected' : '' }}
                    value="{{ $id }}">{{ $nome }}</option>
            @endforeach
        </select>
        @error('filmes')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
@endif

<div class="form-group">
    <label class="form-label text-light">Imagens do Estúdio</label>
    @if (isset($estudio) && $estudio->imagens->isNotEmpty())
        <div class="d-flex flex-wrap gap-3">
            @foreach ($estudio->imagens as $imagem)
                <div class="text-center" id="img-container-{{ $imagem->id }}" style="width: 130px">
                    <img src="{{ asset('storage/' . $imagem->caminho) }}" class="img-thumbnail mb-1"
                        style="height: 90px; width: 120px; object-fit: cover">
                    <button type="button" onclick="excluirImagem({{ $imagem->id }}, {{ $estudio->id }})"
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
        document.addEventListener("DOMContentLoaded", () => {
            if (document.getElementById('filmes')) {
                new TomSelect('#filmes', {
                    plugins: ['remove_button'],
                    create: false,
                    sortField: {
                        field: 'text',
                        direction: 'asc'
                    },
                    render: {
                        no_results: function(data, escape) {
                            return '<div class="no-results">Nenhum filme encontrado</div>';
                        },
                    }
                });
            }
        });

        const container = document.getElementById('campos-imagem');
        const btnAdicionar = document.getElementById('btn-adicionar');
        const MAX_FOTOS = 5;

        btnAdicionar.addEventListener('click', () => {
            const camposAtuais = container.querySelectorAll('.campo-imagem').length;
            const imagensExistentes = {{ isset($estudio) ? $estudio->imagens->count() : 0 }};

            if (camposAtuais + imagensExistentes >= MAX_FOTOS) {
                alert('Máximo de ' + MAX_FOTOS + ' imagens.');
                return;
            }

            const div = document.createElement('div');
            div.className = 'campo-imagem mb-2 d-flex align-items-center gap-2';
            div.innerHTML = `
                <input type="file" name="imagens[]" class="form-control"
                accept="image/jpeg,image/png,image/webp" required>
                <button type="button" class="btn btn-sm btn-outline-danger"
                onclick="this.closest('.campo-imagem').remove();">✕</button>`;
            container.appendChild(div);
        });

        async function excluirImagem(imagemId, estudioId) {
            if (!confirm("Realmente deseja excluir essa imagem?")) {
                return;
            }

            const response = await fetch(`/admin/imagens/${imagemId}/estudio/${estudioId}`, {
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
    </script>
@endpush
