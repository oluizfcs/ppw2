<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Estudio extends Model
{
    use HasFactory;
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

    public function displayFilmes(): String
    {
        $filmes = [];

        foreach ($this->filmes as $filme) {
            $filmes[] = "<a href='" . route('admin.filmes.show', $filme) . "'>{$filme->nome}</a>";
        }

        return implode('<br>', $filmes);
    }
}
