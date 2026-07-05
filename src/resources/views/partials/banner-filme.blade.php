<div class="position-relative">
    <a href="{{ route('filmes.show', $filme) }}">
        @php
            $poster = $filme->poster();
        @endphp
        <img src="{{ $poster ? asset('storage/' . $poster->caminho) : asset('images/filme-card.png') }}"
            alt="{{ $filme->nome }}"
            class="w-100 object-fit-cover"
            style="max-height: 400px;">
        <span class="position-absolute top-0 start-0 badge bg-dark bg-opacity-75 m-2 px-3 py-2 fs-6">
            Lançamentos
        </span>
        <div class="position-absolute bottom-0 start-0 w-100 p-3 text-light" style="background: rgba(0,0,0,0.7);">
            <strong class="fs-4 d-block mb-1">{{ $filme->nome }}</strong>
            <p class="text-truncate mb-0 small text-secondary">{{ $filme->sinopse }}</p>
        </div>
    </a>
</div>
