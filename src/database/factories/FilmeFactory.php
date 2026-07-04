<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FilmeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nome' => fake()->unique()->sentence(3),
            'duracao' => fake()->numberBetween(45, 240),
            'data_lancamento' => fake()->date('Y-m-d', 'now'),
            'classificacao' => fake()->randomElement(['L', '6', '10', '12', '14', '16', '18']),
            'sinopse' => fake()->paragraphs(3, true),
        ];
    }
}
