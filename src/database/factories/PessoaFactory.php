<?php

namespace Database\Factories;

use App\Models\Pessoa;
use Illuminate\Database\Eloquent\Factories\Factory;

class PessoaFactory extends Factory
{
    protected $model = Pessoa::class;

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

    public function configure(): static
    {
        return $this->afterCreating(function (Pessoa $pessoa) {
            if (fake()->boolean(70)) {
                $pessoa->ator()->create();
            }
            if (fake()->boolean(50)) {
                $pessoa->diretor()->create();
            }
            if (fake()->boolean(30)) {
                $pessoa->produtor()->create();
            }
            if (fake()->boolean(40)) {
                $pessoa->escritor()->create();
            }
        });
    }
}
