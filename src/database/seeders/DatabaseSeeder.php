<?php

namespace Database\Seeders;

use App\Models\Ator;
use App\Models\Avaliacao;
use App\Models\Diretor;
use App\Models\Escritor;
use App\Models\Estudio;
use App\Models\Filme;
use App\Models\Imagem;
use App\Models\Pessoa;
use App\Models\Produtor;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

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

        User::factory(200)->create();

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

        Pessoa::factory(90)->create();
        Filme::factory(30)->create();

        $this->seedImagens();
        $this->attachImagensPessoas();
        $this->attachImagensFilmes();
        $this->attachPapeis();

        $this->seedEstudios();

        $filmes = Filme::all();
        $users = User::all();

        foreach ($filmes as $filme) {
            $nAvaliacoes = rand(0, min(100, $users->count()));

            if ($nAvaliacoes === 0) {
                continue;
            }

            $revisores = $users->random($nAvaliacoes);

            foreach ($revisores as $user) {
                Avaliacao::factory()->create([
                    'filme_id' => $filme->id,
                    'usuario_id' => $user->id,
                ]);
            }
        }
    }

    private function seedImagens(): void
    {
        foreach (['pessoas', 'filmes'] as $dir) {
            if (!Storage::disk('public')->exists("imagens/{$dir}")) {
                continue;
            }

            $files = Storage::disk('public')->files("imagens/{$dir}");

            foreach ($files as $path) {
                $filename = pathinfo($path, PATHINFO_FILENAME);
                Imagem::create([
                    'caminho' => $path,
                    'nome' => $filename,
                ]);
            }
        }
    }

    private function attachImagensPessoas(): void
    {
        $imagens = Imagem::where('caminho', 'like', 'imagens/pessoas/%')->get();

        if ($imagens->isEmpty()) {
            return;
        }

        foreach (Pessoa::all() as $pessoa) {
            $pessoa->imagens()->attach($imagens->random()->id);
        }
    }

    private function attachImagensFilmes(): void
    {
        $imagens = Imagem::where('caminho', 'like', 'imagens/filmes/%')->get();

        if ($imagens->isEmpty()) {
            return;
        }

        foreach (Filme::all() as $filme) {
            $selected = $imagens->random(min(3, $imagens->count()));

            foreach ($selected as $i => $imagem) {
                $filme->imagens()->attach($imagem->id, [
                    'poster' => $i === 0,
                ]);
            }
        }
    }

    private function seedEstudios(): void
    {
        $estudios = Estudio::factory(15)->create();

        foreach ($estudios as $estudio) {
            $filmes = Filme::inRandomOrder()->take(rand(1, 10))->pluck('id');
            $estudio->filmes()->attach($filmes);
        }
    }

    private function attachPapeis(): void
    {
        $filmes = Filme::all();
        $atores = Ator::all();
        $diretores = Diretor::all();
        $produtores = Produtor::all();
        $escritores = Escritor::all();

        foreach ($filmes as $filme) {
            $nAtores = min(rand(2, 4), $atores->count());
            if ($nAtores > 0) {
                foreach ($atores->random($nAtores) as $ator) {
                    $filme->atores()->attach($ator->id, [
                        'papel' => fake()->firstName(),
                    ]);
                }
            }

            $nDiretores = min(rand(1, 2), $diretores->count());
            if ($nDiretores > 0) {
                $filme->diretores()->attach(
                    $diretores->random($nDiretores)->pluck('id')
                );
            }

            $nProdutores = min(rand(0, 2), $produtores->count());
            if ($nProdutores > 0) {
                $filme->produtores()->attach(
                    $produtores->random($nProdutores)->pluck('id')
                );
            }

            $nEscritores = min(rand(1, 2), $escritores->count());
            if ($nEscritores > 0) {
                $filme->escritores()->attach(
                    $escritores->random($nEscritores)->pluck('id')
                );
            }
        }
    }
}
