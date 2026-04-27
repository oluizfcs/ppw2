<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Pessoa extends Model
{
    protected $table = 'pessoa';

    protected $fillable = [
        'cpf',
        'nome',
        'data_nascimento',
        'biografia',
        'genero',
        'nacionalidade'
    ];

    public function ator(): HasOne
    {
        return $this->hasOne(Ator::class);
    }

    public function diretor(): HasOne
    {
        return $this->hasOne(Diretor::class);
    }

    public function produtor(): HasOne
    {
        return $this->hasOne(Produtor::class);
    }

    public function escritor(): HasOne
    {
        return $this->hasOne(Escritor::class);
    }

    public function imagens(): HasMany
    {
        return $this->hasMany(Imagem::class);
    }
}
