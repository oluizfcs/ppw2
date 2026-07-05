<div class="col-12 col-sm-6 col-md-4 col-lg-3">
    <a href="{{ route('pessoas.show', $ator) }}" class="text-decoration-none">
        <div class="card h-100 mb-3 bg-dark border-secondary hover-shadow">
            @php
                $foto = $ator->imagens->first();
            @endphp
            <img src="{{ $foto ? asset('storage/' . $foto->caminho) : asset('images/profile.png') }}"
                alt="Foto de {{ $ator->nome }}"
                class="card-img-top object-fit-cover"
                style="height: 250px;">
            <div class="card-body d-flex flex-column">
                <h5 class="card-title fs-5 text-light mb-1">{{ $ator->nome }}</h5>
                <p class="card-text small text-truncate" style="max-width: 200px;">{{ $ator->biografia }}</p>
            </div>
        </div>
    </a>
</div>
