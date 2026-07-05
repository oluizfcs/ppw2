@auth
    <div class="card p-5">
        <h2>{{ $title ?? 'Deixe sua avaliação' }}</h2>
        <form method="POST" action="{{ route('avaliacoes.store') }}">
            @csrf
            <input type="hidden" name="usuario_id" value="{{ auth()->id() }}">
            <input type="hidden" name="filme_id" value="{{ $filme->id }}">

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

            <div class="mb-3">
                <label for="nota" class="form-label fw-semibold me-2">Nota</label>
                <input type="hidden" name="nota" id="nota" class="form-control"
                    value="{{ old('nota', $avaliacao->nota ?? '') }}">
                <span class="input-nota">
                    @for ($i = 0; $i < 5; $i++)
                        <span style="cursor: pointer;">
                            <i data-index="{{ $i }}" class="bi bi-star text-primary fs-3"></i>
                        </span>
                    @endfor
                </span>
            </div>

            <div class="mb-3">
                <label for="titulo" class="form-label fw-semibold">Título</label>
                <input type="text" name="titulo" id="titulo"
                    class="form-control @error('titulo') is-invalid @enderror"
                    value="{{ old('titulo', $avaliacao->titulo ?? '') }}">
                @error('titulo')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="descricao" class="form-label fw-semibold">Avaliação</label>
                <textarea name="descricao" id="descricao" rows="4" class="form-control @error('descricao') is-invalid @enderror">{{ old('descricao', $avaliacao->descricao ?? '') }}</textarea>
                @error('descricao')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary">Postar Avaliação</button>
            </div>
        </form>
    </div>

    <script>
        {
            const form = document.querySelector('#nota').closest('form');
            const inputNotaHidden = form.querySelector('input[name="nota"]');
            const inputNota = form.querySelector('.input-nota');
            const stars = inputNota.querySelectorAll('span');
            let clicked = false;

            stars.forEach((starContainer) => {
                starContainer.addEventListener('mouseover', () => {
                    if (clicked) return;
                    const idx = parseInt(starContainer.querySelector('i').dataset.index);
                    stars.forEach((span) => {
                        if (parseInt(span.querySelector('i').dataset.index) <= idx) {
                            span.querySelector('i').classList.replace('bi-star', 'bi-star-fill');
                        }
                    });
                });

                starContainer.addEventListener('mouseleave', () => {
                    if (clicked) return;
                    stars.forEach((span) => {
                        span.querySelector('i').classList.replace('bi-star-fill', 'bi-star');
                    });
                });

                starContainer.addEventListener('click', () => {
                    const idx = parseInt(starContainer.querySelector('i').dataset.index);
                    stars.forEach((span) => {
                        if (parseInt(span.querySelector('i').dataset.index) <= idx) {
                            span.querySelector('i').classList.replace('bi-star', 'bi-star-fill');
                        } else {
                            span.querySelector('i').classList.replace('bi-star-fill', 'bi-star');
                        }
                    });
                    clicked = true;
                    inputNotaHidden.value = inputNota.querySelectorAll('.bi-star-fill').length;
                });
            });

            if (inputNotaHidden.value != '') {
                const el = inputNota.querySelector('[data-index="' + (parseInt(inputNotaHidden.value) - 1) + '"]');
                if (el) el.click();
            }
        }
    </script>
@endauth
