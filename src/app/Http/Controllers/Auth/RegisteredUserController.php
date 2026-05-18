<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $dados = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', 'min:3'], // Rules\Password::defaults()
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if ($request->hasFile('foto_perfil')) {
            $caminho = $request->file('foto_perfil')->store('profiles', 'public');
            $dados['foto_perfil_url'] = $caminho;

            try {
                DB::transaction(function () use ($user, $dados) {
                    DB::table('foto_perfil')->insert([
                        'usuario_id' => $user->id,
                        'nome' => $user->name,
                        'caminho' => $dados['foto_perfil_url']
                    ]);
                });
            } catch(\Exception $e) {
                if ($caminho) {
                    Storage::disk('public')->delete($caminho);
                }
                return back()->with('error', 'Erro ao cadastrar usuário. Tente novamente.');
            }
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('admin', absolute: false));
    }
}
