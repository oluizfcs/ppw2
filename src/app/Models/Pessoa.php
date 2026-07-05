<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Pessoa extends Model
{
    use HasFactory;
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

    public function imagens(): BelongsToMany
    {
        return $this->belongsToMany(Imagem::class, 'imagem_pessoa')->withTimestamps();
    }

    public function displayFilmes(): String
    {
        $filmes = [];

        if ($this->ator) {
            foreach ($this->ator->filmes as $filme) {
                $papel = $filme->pivot->papel ?? null;
                $filmes[] = "<a href='" . route('admin.filmes.show', $filme) . "'>{$filme->nome}</a> - ator" . ($papel ? " ({$papel})" : '');
            }
        }
        if ($this->diretor) {
            foreach ($this->diretor->filmes as $filme) {
                $filmes[] = "<a href='" . route('admin.filmes.show', $filme) . "'>{$filme->nome}</a> - diretor";
            }
        }
        if ($this->produtor) {
            foreach ($this->produtor->filmes as $filme) {
                $filmes[] = "<a href='" . route('admin.filmes.show', $filme) . "'>{$filme->nome}</a> - produtor";
            }
        }
        if ($this->escritor) {
            foreach ($this->escritor->filmes as $filme) {
                $filmes[] = "<a href='" . route('admin.filmes.show', $filme) . "'>{$filme->nome}</a> - escritor";
            }
        }

        return implode('<br>', $filmes);
    }
}
