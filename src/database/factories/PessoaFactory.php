<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PessoaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'cpf' => fake('pt_BR')->unique()->cpf(),
            'nome' => fake('pt_BR')->name(),
            'data_nascimento' => fake()->date('Y-m-d', '2010-10-10'),
            'biografia' => fake()->paragraphs(3, true),
            'genero' => fake()->text('10'),
            'nacionalidade' => fake('pt_BR')->country(),
        ];
    }
}
