<?php

namespace Database\Factories;

use App\Models\Avaliacao;
use Illuminate\Database\Eloquent\Factories\Factory;

class AvaliacaoFactory extends Factory
{
    protected $model = Avaliacao::class;

    public function definition(): array
    {
        return [
            'nota' => fake()->numberBetween(2, 5),
            'titulo' => fake()->sentence(2),
            'descricao' => fake()->paragraph(2),
        ];
    }
}
