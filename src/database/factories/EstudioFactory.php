<?php

namespace Database\Factories;

use App\Models\Estudio;
use Illuminate\Database\Eloquent\Factories\Factory;

class EstudioFactory extends Factory
{
    protected $model = Estudio::class;

    public function definition(): array
    {
        return [
            'nome' => fake('pt_BR')->unique()->company(),
            'local' => fake('pt_BR')->city(),
        ];
    }
}
