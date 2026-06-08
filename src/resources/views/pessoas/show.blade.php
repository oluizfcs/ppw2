@extends('layouts.app')

@section('titulo', 'Moviestar - ' . $pessoa->nome)

@section('conteudo')
    <div class="container min-vh-100 mt-4 col-lg-8">
        <div class="row">
            <div class="clearfix">
                <img src="{{ asset($pessoa->imagens->isNotEmpty() ? 'storage/' . $pessoa->imagens->first()->caminho : 'images/profile.png') }}"
                    alt="Foto de {{ $pessoa->nome }}" class="img-fluid rounded shadow-sm mb-3 float-start"
                    style="width: 20%; max-height: 450px; object-fit: cover; margin: 10px;">
                    <h1 class="mb-3">{{ $pessoa->nome }}</h1>
                    <span>{{ $pessoa->biografia }} Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ad expedita, explicabo perspiciatis neque optio quo ullam error quibusdam facere. Voluptate labore sit eveniet totam delectus culpa, dolor similique vitae molestias! Lorem ipsum dolor sit amet consectetur adipisicing elit. Enim magni porro sed atque non tenetur amet, veniam autem quas iusto omnis quod ad doloribus temporibus eligendi voluptatum consequuntur ab pariatur. Lorem ipsum, dolor sit amet consectetur adipisicing elit. Accusantium, quibusdam fugiat dignissimos in mollitia, nulla quidem, expedita libero suscipit deserunt labore repudiandae aspernatur earum et? Et quidem molestias nam sint? Lorem, ipsum dolor sit amet consectetur adipisicing elit. Ratione voluptatem dolorem deserunt a nesciunt nobis atque laboriosam perspiciatis facilis, ipsam quasi nam ipsum suscipit harum temporibus consequatur itaque delectus doloremque.</span>
            </div>
            <hr>
            <div>
                <h2>Atuou em</h2>
                <h2>Dirigiu</h2>
                <h2>Escreveu</h2>
                <h2>Produziu</h2>
            </div>
        </div>
    </div>
@endsection
