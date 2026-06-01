<div class="col-md-3">
    <div class="card mb-2 bg-dark border-secondary">
        <div class="card-body">
            <div class="row fs-3">
                <div class="col">{{ $avaliacao['filme'] }}</div>
                <div class="col text-end">{{ $avaliacao['nota'] }} <img src="{{ asset('images/star.png') }}" class="mb-2"
                        alt="" width="24" height="24"></div>
            </div>
            <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Beatae praesentium tenetur sint suscipit.
                Nostrum adipisci cupiditate voluptas quia voluptatem commodi harum nam! Nulla dolore quo animi assumenda
                voluptates, blanditiis corporis.</p>
            <strong>{{ $avaliacao['usuario'] }}</strong>
        </div>
    </div>
</div>
