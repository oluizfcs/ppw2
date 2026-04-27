<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Filme extends Model
{
    protected $table = 'filme';

    protected $fillable = [
        'nome',
        'duracao',
        'data_lancamento',
        'classificacao',
        'sinopse'
    ];

    public function avaliacoes(): HasMany
    {
        return $this->hasMany(Avaliacao::class);
    }

    public function atores(): BelongsToMany
    {
        return $this->belongsToMany(Ator::class)
        ->withPivot('papel')->withTimestamps();
    }
    
    public function diretores(): BelongsToMany
    {
        return $this->belongsToMany(Diretor::class);
    }
    
    public function produtores(): BelongsToMany
    {
        return $this->belongsToMany(Produtor::class, 'produtor_filme');
    }
    
    public function escritores(): BelongsToMany
    {
        return $this->belongsToMany(Escritor::class);
    }

    public function estudios(): BelongsToMany
    {
        return $this->belongsToMany(Estudio::class);
    }

    public function imagens(): BelongsToMany
    {
        return $this->belongsToMany(Imagem::class, 'imagem_filme');
    }

    public function generos(): BelongsToMany
    {
        return $this->belongsToMany(Genero::class);
    }
}
