<?php

namespace Database\Seeders;

use App\Models\Filme;
use App\Models\Genero;
use App\Models\Pessoa;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('123'),
            'admin' => true
        ]);

        User::factory(10)->create();
        Pessoa::factory(10)->create();
        Filme::factory(10)->create();

        $generos = [
            'ação',
            'aventura',
            'comédia',
            'drama',
            'ficção científica',
            'terror',
            'romance',
            'suspense',
            'fantasia',
            'musical',
            'animação'
        ];

        DB::table('genero')->insert(
            array_map(fn($nome) => ['nome' => $nome], $generos)
        );
    }
}
