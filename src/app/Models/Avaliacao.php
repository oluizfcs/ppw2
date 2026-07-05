<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Avaliacao extends Model
{
    use HasFactory;
    protected $table = 'avaliacao';

    protected $fillable = [
        'filme_id',
        'usuario_id',
        'nota',
        'titulo',
        'descricao'
    ];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function filmes(): BelongsTo
    {
        return $this->belongsTo(Filme::class);
    }
}
