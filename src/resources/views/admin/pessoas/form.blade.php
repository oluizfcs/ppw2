<div class="form-floating mb-3">
    <input type="text" autofocus class="form-control @error('nome') is-invalid @enderror" id="nome" name="nome"
        value="{{ old('nome', $pessoa->nome ?? 'Fulano') }}" placeholder="Nome completo">
    <label for="nome">Nome:</label>
    @error('nome')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-floating mb-3">
    <input type="text" class="form-control @error('cpf') is-invalid @enderror" id="cpf" name="cpf"
        value="{{ old('cpf', $pessoa->cpf ?? '000.000.000-00') }}" placeholder="000.000.000-00">
    <label for="cpf">CPF:</label>
    @error('cpf')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-floating mb-3">
    <input type="date" class="form-control @error('data_nascimento') is-invalid @enderror" id="data_nascimento"
        name="data_nascimento" value="{{ old('data_nascimento', $pessoa->data_nascimento ?? '1999-01-01') }}"
        placeholder="Data de Nascimento">
    <label for="data_nascimento">Data de Nascimento:</label>
    @error('data_nascimento')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-floating mb-3">
    <input type="text" class="form-control @error('genero') is-invalid @enderror" id="genero" name="genero"
        value="{{ old('genero', $pessoa->genero ?? 'x') }}" placeholder="Genero">
    <label for="genero">Gênero:</label>
    @error('genero')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-floating mb-3">
    <input type="text" class="form-control @error('nacionalidade') is-invalid @enderror" id="nacionalidade"
        name="nacionalidade" value="{{ old('nacionalidade', $pessoa->nacionalidade ?? 'Brasileira') }}"
        placeholder="Nacionalidade">
    <label for="nacionalidade">Nacionalidade:</label>
    @error('nacionalidade')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-floating mb-3">
    <textarea class="form-control @error('biografia') is-invalid @enderror" id="biografia" name="biografia"
        style="height: 120px" placeholder="Biografia">{{ old('biografia', $pessoa->biografia ?? 'Nascido(a) em...') }}</textarea>
    <label for="biografia">Biografia:</label>
    @error('biografia')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

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
        const container = document.getElementById('campos-imagem');
        const btnAdicionar = document.getElementById('btn-adicionar');
        let indice = 1;
        const MAX_FOTOS = 5;

        btnAdicionar.addEventListener('click', () => {
            const camposAtuais = container.querySelectorAll('.campo-imagem').length;
            const imagensExistentes = {{ isset($pessoa) ? $pessoa->imagens->count() : 0 }};

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

        async function excluirImagem(imagemId, pessoaId) {
            if (!confirm("Realmente deseja excluir essa imagem?")) {
                return;
            }

            const response = await fetch(`/imagens/${imagemId}/pessoa/${pessoaId}`, {
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
                alert("Imagem removida!");
            }
        }
    </script>
@endpush
