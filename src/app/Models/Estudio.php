<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Estudio extends Model
{
    protected $table = 'estudio';

    protected $fillable = [
        'nome',
        'local'
    ];

    public function imagens(): BelongsToMany
    {
        return $this->belongsToMany(Imagem::class, 'imagem_estudio')->withTimestamps();
    }

    public function filmes(): BelongsToMany
    {
        return $this->belongsToMany(Filme::class);
    }
}
