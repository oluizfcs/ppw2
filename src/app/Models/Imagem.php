<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Imagem extends Model
{
    protected $table = 'imagem';

    protected $fillable = [
        'caminho',
        'nome'
    ];

    public function pessoa(): BelongsToMany
    {
        return $this->belongsToMany(Pessoa::class, 'imagem_pessoa')->withTimestamps();
    }

    public function filmes(): BelongsToMany
    {
        return $this->belongsToMany(Filme::class, 'imagem_filme');
    }

    public function estudios(): BelongsToMany
    {
        return $this->belongsToMany(Estudio::class, 'imagem_estudio')->withTimestamps();
    }
}
