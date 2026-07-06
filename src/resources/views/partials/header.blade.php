<header class="p-3 border-bottom bg-dark sticky-md-top">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-evenly">
            <a id="logo-link" href="/"
                class="d-flex align-items-center mb-2 mb-lg-0 link-body-emphasis text-decoration-none">
                <img src="{{ asset('images/star.svg') }}" class="me-1 mb-2" width="32px" height="32px" alt="brand logo">
                <span class="brand-name fs-2 me-2">Movie<span class="text-primary">star</span></span>
            </a>
            @auth
                @if (Auth::user()->isAdmin())
                    <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                        <li>
                            <a href="/" class="nav-link px-2 link-body-emphasis">Home</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.filmes.index') }}" class="nav-link px-2 link-body-emphasis">Filmes</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.pessoas.index') }}"
                                class="nav-link px-2 link-body-emphasis">Pessoas</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.generos.index') }}"
                                class="nav-link px-2 link-body-emphasis">Gêneros</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.estudios.index') }}"
                                class="nav-link px-2 link-body-emphasis">Estúdios</a>
                        </li>
                    </ul>
                @endif
            @endauth
            <form action="/buscar" method="GET" class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" role="search">
                <input type="search" name="q" value="{{ request('q') }}" class="form-control"
                    placeholder="Pesquisar..." aria-label="Search">
            </form>
            @auth
                <div class="dropdown text-end">
                    <a href="{{ route('profile') }}" class="d-block link-body-emphasis text-decoration-none dropdown-toggle"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ Auth::user()->getProfilePictureUrlPath() }}" alt="foto do usuário" width="32"
                            height="32" class="rounded-circle">
                    </a>
                    <ul class="dropdown-menu text-small">
                        {{-- <li><a class="dropdown-item" href="#">Configurações</a></li> --}}
                        <li><a class="dropdown-item" href="{{ route('profile') }}">Perfil</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form action="{{ route('logout') }}" method="post">
                                @csrf
                                <button type="submit" class="dropdown-item">Sair</button>
                            </form>
                        </li>
                    </ul>
                </div>
            @else
                <div>
                    <a href="/login" class="btn btn-primary">Entrar</a>
                    <a href="/register" class="btn">Cadastrar</a>
                </div>
            @endauth
        </div>
    </div>
</header>
