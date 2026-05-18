<!DOCTYPE html>
<html lang='pt-BR' data-bs-theme="dark">

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <title>@yield('titulo', 'Moviestar')</title>
    @vite(['resources/css/app.scss', 'resources/js/app.js'])
    @stack('styles')
</head>

<body>
    @include('partials.header')
    <main class="min-vh-100 mt-5 mb-5">
        <div class="container mt-2">
            @session('error')
                <div class="alert alert-danger" role="alert">
                    {{ $value }}
                </div>
            @endsession
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger" role="alert">
                        {{ $error }}
                    </div>
                @endforeach
            @endif
            @session('success')
                <div class="alert alert-success" role="alert">
                    {{ $value }}
                </div>
            @endsession
        </div>
        @yield('conteudo')
    </main>
    @include('partials.footer')
    @stack('scripts')
</body>

</html>
