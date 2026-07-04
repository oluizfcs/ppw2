<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Filme extends Model
{
    use HasFactory;
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
        return $this->belongsToMany(Imagem::class, 'imagem_filme')
            ->withPivot('poster');
    }

    public function generos(): BelongsToMany
    {
        return $this->belongsToMany(Genero::class);
    }

    public function poster(): Imagem|null
    {
        return $this->imagens->filter(fn($img) => $img->pivot->poster)->first();
    }

    public function displayGeneros($limit = null): String
    {
        return implode(", ", array_slice($this->generos->pluck("nome")->all(), 0, $limit));
    }

    public function displayEstudios($limit = null): String
    {
        return implode(", ", array_slice($this->estudios->pluck("nome")->all(), 0, $limit));
    }

    public function displayPessoas(): String
    {
        $pessoas = [];

        foreach ($this->atores as $ator) {
            $pessoas[] = "<a href='" . route('admin.pessoas.show', $ator->pessoa) . "'>{$ator->pessoa->nome}</a> - ator ({$ator->pivot->papel})";
        }
        foreach ($this->diretores as $diretor) {
            $pessoas[] = "<a href='" . route('admin.pessoas.show', $diretor->pessoa) . "'>{$diretor->pessoa->nome}</a> - diretor";
        }
        foreach ($this->produtores as $produtor) {
            $pessoas[] = "<a href='" . route('admin.pessoas.show', $produtor->pessoa) . "'>{$produtor->pessoa->nome}</a> - produtor";
        }
        foreach ($this->escritores as $escritor) {
            $pessoas[] = "<a href='" . route('admin.pessoas.show', $escritor->pessoa) . "'>{$escritor->pessoa->nome}</a> - escritor";
        }

        return implode(', ', $pessoas);
    }
}
