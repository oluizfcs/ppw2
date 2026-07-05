<hr>
<h2>{{ $listLabel }}</h2>

<div class="row">
    @foreach ($cardList as $item)
        <div
            class="d-flex flex-column flex-sm-row align-items-center align-items-sm-start p-3 gap-3 border-secondary-subtle">

            <div class="flex-shrink-0">
                <img src="{{ $item['img'] ?? asset('images/filme-card.png') }}" alt=""
                    class="rounded-circle border border-1 border-secondary"
                    style="width: 80px; height: 80px; object-fit: cover;">
            </div>

            <div class="text-center text-sm-start w-100">
                <p class="fw-bold mb-1 fs-5"><a href="{{ route('filmes.show', $item['obj']) }}">{{ $item['title'] }}</a>
                </p>
                @if ($item['subtitle'])
                    <p class="text-muted mb-0">{{ $item['subtitle'] }}</p>
                @endif
            </div>
        </div>
    @endforeach
</div>
