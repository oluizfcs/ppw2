<?php

namespace Database\Factories;

use App\Models\Filme;
use App\Models\Genero;
use Illuminate\Database\Eloquent\Factories\Factory;

class FilmeFactory extends Factory
{
    protected $model = Filme::class;

    public function definition(): array
    {
        return [
            'nome' => fake()->unique()->words(3, true),
            'duracao' => fake()->numberBetween(45, 240),
            'data_lancamento' => fake()->date('Y-m-d', 'now'),
            'classificacao' => fake()->randomElement(['L', '6', '10', '12', '14', '16', '18']),
            'sinopse' => fake()->paragraphs(3, true),
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Filme $filme) {
            $generos = Genero::inRandomOrder()->take(rand(1, 3))->pluck('id');
            $filme->generos()->attach($generos);
        });
    }
}
