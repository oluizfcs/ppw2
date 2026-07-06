<div class="col-12 col-sm-6 col-md-4 col-lg-3">
    <div class="card h-100 mb-3 bg-dark border-secondary hover-shadow" data-bs-toggle="modal"
        data-bs-target="#reviewModal-{{ $avaliacao->id }}" style="cursor: pointer;">

        <div class="card-body d-flex flex-column justify-content-between p-3">
            <div>
                <div class="row align-items-start mb-2">
                    <div class="col-8">
                        <div class="d-flex align-items-center gap-2">
                            @php
                                $avaliacaoFilme = $avaliacao->filme;
                                $poster = $avaliacaoFilme?->poster();
                            @endphp
                            <img src="{{ $poster ? asset('storage/' . $poster->caminho) : asset('images/filme-card.png') }}"
                                alt="" class="rounded-circle object-fit-cover flex-shrink-0" width="24"
                                height="24">
                            <h5 class="text-light fw-bold lh-sm text-truncate mb-0">{{ $avaliacaoFilme?->nome }}</h5>
                        </div>
                    </div>
                    <div class="col-4 text-end d-flex align-items-center justify-content-end gap-1 text-warning">
                        <span class="fw-bold text-light fs-5">{{ $avaliacao->nota }}</span>
                        <img src="{{ asset('images/star.png') }}" alt="Estrela" width="20" height="20"
                            class="mb-1">
                    </div>
                </div>

                <p class="text-truncate mb-1">
                    {{ $avaliacao->titulo }}
                </p>
                <p class="text-secondary small text-truncate mb-3">
                    {{ $avaliacao->descricao }}
                </p>
            </div>

            <div class="d-flex align-items-center gap-2 mt-auto">
                <img src="{{ $avaliacao->usuario?->getProfilePictureUrlPath() }}" alt=""
                    class="rounded-circle object-fit-cover flex-shrink-0" width="20" height="20">
                <strong class="text-light small text-truncate">{{ $avaliacao->usuario?->name }}</strong>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="reviewModal-{{ $avaliacao->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark border-secondary text-light">
            <div class="modal-header border-bottom border-secondary">
                <p class="modal-title fw-bold fs-5">
                    <a href="{{ route('filmes.show', $avaliacaoFilme) }}">{{ $avaliacaoFilme?->nome }}</a>
                    <span>(<i class="bi bi-star-fill"></i>
                        {{ $avaliacaoFilme?->displayNota() }})</span>
                </p>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex align-items-center gap-1 text-warning mb-3">
                    <span class="fw-bold text-light fs-4">{{ $avaliacao->nota }} / 5</span>
                    <img src="{{ asset('images/star.png') }}" alt="Estrela" width="24" height="24">
                </div>

                <p class="fw-bold">{{ $avaliacao->titulo }}</p>
                <p class="lh-base" style="white-space: pre-wrap;">{{ $avaliacao->descricao }}</p>
            </div>
            <div class="modal-footer border-top border-secondary justify-content-between">
                <small class="text-secondary">Avaliado por:
                    <a
                        href="{{ route('profile.show', $avaliacao->usuario) }}">{{ $avaliacao->usuario?->name }}</a></small>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
