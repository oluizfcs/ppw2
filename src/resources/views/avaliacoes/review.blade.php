<div id="avaliacao-{{ $avaliacao->id }}" class="card shadow-sm border-secondary mb-3">
    <div class="card-body">
        <div class="clearfix p-2">
            <div class="float-start me-3 mb-2">
                <img src="{{ $avaliacao->usuario->getProfilePictureUrlPath() }}"
                    alt="Foto de {{ $avaliacao->usuario->name }}" class="rounded-circle border border-1 border-secondary"
                    style="width: 60px; height: 60px; object-fit: cover;">
            </div>

            <div class="d-flex align-items-center gap-2 mb-1">
                <h3 class="fs-5 mb-0">{{ $avaliacao->usuario->name }}</h3>
            </div>

            @php $stars = max(1, min(5, (int) $avaliacao->nota)); @endphp
            <span class="small">
                @for ($i = 0; $i < $stars; $i++)
                    <i class="bi bi-star-fill text-primary"></i>
                @endfor
                @for ($i = $stars; $i < 5; $i++)
                    <i class="bi bi-star text-primary"></i>
                @endfor
            </span>

            @if ($avaliacao->titulo)
                <h4 class="fs-6 fw-bold mb-0">{{ $avaliacao->titulo }}</h4>
            @endif

            <div class="mb-2">
                {{ $avaliacao->descricao }}
            </div>

            @auth
                @if (auth()->id() === $avaliacao->usuario_id || auth()->user()->isAdmin())
                    <div class="text-end">
                        @if (auth()->id() === $avaliacao->usuario_id)
                            <button type="button" data-bs-toggle="modal"
                                data-bs-target="#edit-review-modal-{{ $avaliacao->id }}"
                                class="btn btn-sm btn-outline-primary">Editar</button>
                        @endif
                        <form action="{{ route('avaliacoes.destroy', $avaliacao->id) }}" method="POST" class="d-inline"
                            onsubmit="return confirm('Você tem certeza?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">Excluir</button>
                        </form>
                    </div>
                @endif
            @endauth
        </div>
    </div>
</div>
