<div>
    <a href="/produtos/{{$produto['id']}}">{{ $produto['nome'] }}</a>
    <span>R$ {{ number_format($produto['preco'], 2, ',', '.') }}</span>
</div>